# Building
[![Build Status](https://travis-ci.org/nicmart/Building.png?branch=master)](https://travis-ci.org/nicmart/Building)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/nicmart/Building/badges/quality-score.png?s=397025170a33be1128fdf16c59e2ed30265dfb9e)](https://scrutinizer-ci.com/g/nicmart/Building/)

Building is, more than a library, a suggestion on how to model fluent builders in your php code.

## What is a fluent builder

Building the object graph of the instances of your object model requires often hard to read lines of code,
with a lot of nested instantiations and method calls.

In that case you can benefit from a [Fluent Builder](http://martinfowler.com/dslCatalog/expressionBuilder.html),
adding an easy-to-read and easy-to-write separate API on top of your object API.

The builder offers an alternative API for the construction of your objects, and its fluent interface helps
the code to be readable and more [DSL](http://en.wikipedia.org/wiki/Domain-specific_language)-oriented.

## How Building works

The approach of this library is using nested builders to define complex objects, and the key point is passing a "finalizing callback", from the parent builder to the child one,
that will be called by the child builder when the subvalue has been built.

This decouples completely the child builder from the parent: the responsability of
what to do with the builded object lies completely on the parent builder.

## A simple example

Let's see now a little example which explains how to define a builder for boolean predicates.
The example is really simple and it could be improved a lot, but it is fine for our purpose.

You have atomic predicates, like equalities and inequalities, and composite ones, like ANDS and ORS:

```php
interface BooleanPredicate
{
    /** @return bool **/
    public function evaluate($value);
}

class EqualityPredicate implements BooleanPredicate
{
    public function __construct($valueToBeEqualTo) { ... }
    ...
}

class GreaterThanPredicate implements BooleanPredicate
{
    public function __construct($greaterThan) { ... }
    ...
}

class LssThanPredicate implements BooleanPredicate
{
    public function __construct($greaterThan) { ... }
    ...
}

interface CompositePredicate extends BooleanPredicate
{
   /** @return $this **/
   public function add(BooleanPredicate $predicate);
}

class OrPredicate implements CompositePredicate
{
   /** @return $this **/
   public function add(BooleanPredicate $predicate) { ... }
}

class AndPredicate implements CompositePredicate
{
   /** @return $this **/
   public function add(BooleanPredicate $predicate) { ... }
}
```

The expression 
```
(x > 0 AND x < 10) OR ((x > 20 AND x < 30) OR x = 40) OR x > 100
```
will be represented in your model by the code

```php
$predicate = (new OrPredicate)
    ->add((new AndPredicate)
        ->add(new GreaterThanPredicate(0))
        ->add(new LessThanPredicate(10))
    )
    ->add((new OrPredicate)
        ->add((new AndPredicate)
            ->add(new GreaterThanPredicate(20))
            ->add(new LessThanPredicate(30))
        )
        ->add(new EqualityPredicate(40))
    )
    ->add(new GreaterThanPredicate(100))
;
```

Let's now define a builder for our predicates.

A builder implements the interface `NicMart\Building\Builder`, and in the library you can
find an abstract class, `NicMart\Building\AbstractBuilder`, that implements the methods of
that interface for you.

A Builder, as you can see by the interface, does exactly two things: it provides a way to 
set a callback and implements an `end()` method that will be called by the client code
when the building of the object has ended. The `end()` method will call the callback and returns 
the returned value.

In this way the builder's responsability is only to build the value, and it delegates completely 
to the parent builder (calling the callback passed by the parent builder) the responsability to
deal with the just builded subvalue.

Going back to our example will clarify the process.

```php
use NicMart\Building\AbstractBuilder;

abstract class CompositePredicateBuilder extends AbstractBuilder
{
    /** @var CompositePredicate **/
    protected $building;
    
    public function eq($value)
    {
        $this->building->add(new EqualityPredicate($value));
        
        return $this;
    }
    
    public function greaterThan($value)
    {
        $this->building->add(new GreaterThanPredicate($value));
        
        return $this;
    }
    
    public function lessThan($value)
    {
        $this->building->add(new LessThanPredicate($value));
        
        return $this;
    }
    
    public function and()
    {
        return new AndPredicate($this->getAddCallback());
    }
    
    public function or()
    {
        return new OrPredicate($this->getAddCallback());
    }
    
    /** @return callable **/
    private function getAddCallback()
    {
        return function(BooleanPredicate $predicate)
        {
            $this->getCompositePredicate()->add($predicate);
            
            // This will be the return value of the end() method
            return $this;
        };
    }
}

class OrPredicateBuilder extends CompositePredicateBuilder
{
    public function __construct(callable $callback = null)
    {
        $this->building = new OrPredicate;
    }
}

class AndPredicateBuilder extends CompositePredicateBuilder
{
    public function __construct(callable $callback = null)
    {
        $this->building = new AndPredicate;
    }
}
```

We can now use the builder to define our predicate in a way closer to the domain of boolean expressions:

```php
$or = new OrPredicateBuilder;

$predicate = 
    $or
       ->and()
          ->greaterThan(0)
          ->lessThan(10)
       ->end()
       ->or()
          ->and()
              ->greaterThan(20)
              ->lessThan(30)
          ->end()
          ->eq(40)
       ->end()
       ->greaterThan(100)
    ->end()
;

$predicate->evaluate(25); // True
$predicate->evaluate(0);  // False
```

The last `end()` automatically returns the builded object because, by default,
the abstract builder class sets for itself a callback that returns
the builded value.

### Other examples
For testing purposes I have included an [ArrayBuilder](https://github.com/nicmart/Building/blob/master/examples/Array.php) 
and an [ObjectBuilder](https://github.com/nicmart/Building/blob/master/examples/Object.php) in the repository.

## Drawbacks

You have to be aware of some drawbacks of fluent interfaces and method chaining in general:

- Code completion: although there is no use of magic methods, the specific builder type returned by the `end()`
  is known only at runtime, so IDES fail to autocomplete builder methods after an `end()`.
- You often violate the [Law Of Demeter](http://en.wikipedia.org/wiki/Law_of_Demeter) when using nested builders.
- [Marco Pivetta](https://twitter.com/Ocramius) thinks that
[fluent interfaces are evil](http://ocramius.github.io/blog/fluent-interfaces-are-evil/). There are a lot of good points
 there, but I think that the concept of "Contract" expressed there is much more restrictive than the language itself
 (or, better, the phpdoc type system) can ensure.

## Bibliography
 - [Domain Specific Languages](http://www.amazon.com/Domain-Specific-Languages-Addison-Wesley-Signature-Fowler/dp/0321712943/ref=la_B000AQ6PGM_1_6?s=books&ie=UTF8&qid=1402352401&sr=1-6) - Martin Fowler (chapters 32-35)

## Install

The best way to install Building is [through composer](http://getcomposer.org).

Just create a composer.json file for your project:

```JSON
{
    "require": {
        "nicmart/building": "~0.2"
    }
}
```

Then you can run these two commands to install it:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install

or simply run `composer install` if you have have already [installed the composer globally](http://getcomposer.org/doc/00-intro.md#globally).

Then you can include the autoloader, and you will have access to the library classes:

```php
<?php
require 'vendor/autoload.php';
```

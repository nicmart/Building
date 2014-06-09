# Building
[![Build Status](https://travis-ci.org/nicmart/Building.png?branch=master)](https://travis-ci.org/nicmart/Building)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/nicmart/Building/badges/quality-score.png?s=397025170a33be1128fdf16c59e2ed30265dfb9e)](https://scrutinizer-ci.com/g/nicmart/Building/)

Building, more than a library, is a suggestion on how to model fluent builders in your code.

## What is a fluent builder

Building the object graph of the instances of your object model requires often hard to read lines of code,
with a lot of nested instantiations and method calls.

In that case you can benefit from a [Fluent Builder](http://martinfowler.com/dslCatalog/expressionBuilder.html),
adding an easy-to-read and easy-to-write separate API on top of your object API.

The builder offers an alternative API for the construction of your objects, and its fluent interface helps
the code to be readable and more [DSL](http://en.wikipedia.org/wiki/Domain-specific_language)-oriented.

## How Building works

The approach of this library is to use nested builders to define complex objects. Basically the building process is:

1. Builder creation - this usually initialize the object to be built
2. Object manipulation - The builder provides some method to directly manipulate the object
3. SubBuilder delegation - The most important part. The builder creates and return a subbuilder, passing a
 a callback to it that will be called when the subvalue will be built.
4. The SubBuilder returns the scope to the parent builder - The SubBuilder callback, that was passed by the parent
  builder, is called, and the subvalue is managed by the parent builder.

The callback passing to the subbuilder decouples completely the child builder from the parent: the responsability of
what doing with the builded object is completely on the parent builder.

## Drawbacks

You have to be aware of some drawbacks of fluent interface and method chaining in general:

- Code completion: although there is no use of magic methods, the specific builder type returned by the `end()`
  is known only at runtime, so IDES fail to autocomplete builder methods after an `end()`.
- You often violate the [Law Of Demeter](http://en.wikipedia.org/wiki/Law_of_Demeter) when using nested builders.
- [Marco Pivetta](https://twitter.com/Ocramius) thinks that
[fluent interfaces are evil](http://ocramius.github.io/blog/fluent-interfaces-are-evil/). There are a lot of good points
 there, but I think that the concept of "Contract" expressed there is much more restrictive than the language itself
 (or, better, the phpdoc type system) can ensure.

## Bibliography
 - [Domain Specific Languages](http://www.amazon.com/Domain-Specific-Languages-Addison-Wesley-Signature-Fowler/dp/0321712943/ref=la_B000AQ6PGM_1_6?s=books&ie=UTF8&qid=1402352401&sr=1-6) - Martin Fowler (chapters 32-35)

in that article, but I thinks

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
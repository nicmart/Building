# Building
[![Build Status](https://travis-ci.org/nicmart/Building.png?branch=master)](https://travis-ci.org/nicmart/Building)
[![Coverage Status](https://coveralls.io/repos/nicmart/Building/badge.png?branch=master)](https://coveralls.io/r/nicmart/Building?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/nicmart/Building/badges/quality-score.png?s=397025170a33be1128fdf16c59e2ed30265dfb9e)](https://scrutinizer-ci.com/g/nicmart/Building/)

A PHP library that abstracts the definition of fluent builders.

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
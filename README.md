## Container [![Build Status](https://travis-ci.org/kenphp/container.svg?branch=master)](https://travis-ci.org/kenphp/container)
A simple PSR-11 compliant PHP container.
This library is part of KenPHP Project, but can be used independently.

## Requirements
- PHP 7.0 or greater

## Instalation
The easiest way to install is using Composer
```
$ composer require kenphp/container
```

## Methods
List of available methods :
- `get($id)`

    Finds an entry of the container by its identifier and returns it.
- `has($id)`

    Returns true if the container can return an entry for the given identifier. Returns false otherwise.
- `set($id, $item)`

    Sets an item into container. The `item` can be a value or a function. If the function returns an object, it will be treated as a singleton.
- `setFactory($id, callable $factory)`

    Sets an object factory. The `factory` must be an instance of `callable` that returns an object and the `factory` will be called whenever the item is fetched using `get` method.

## Example
```php
<?php
use Ken\Container\Container;

$container = new Container();

// Sets item with identifier `Mock1`
$container->set(Mock1::class, function(Container $c) {
    return new Mock1();
});

// Sets item with identifier `Mock2`
$container->set(Mock2::class, function(Container $c) {
    $m1 = $c->get(Mock1::class);
    return new Mock2($m1);
});

// Sets item with identifier `app_name`
$container->set('app_name', 'Application Title');

// Gets item with identifier `Mock1`
$mock1 = $container->get(Mock1::class);

$mock2 = $container->get(Mock2::class);

echo $container->get('app_name'); // prints `Application Title`

```

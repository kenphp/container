## Container
A simple PSR-11 compliant PHP container.
This library is part of KenPHP Project, but can be used independently.

## Requirements
- PHP 5.6 or greater

## Instalation
The easiest way to install is using Composer
```
$ composer require kenphp/container
```

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

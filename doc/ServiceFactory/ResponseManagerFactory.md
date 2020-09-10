# ResponseManagerFactory

## without name (default)

```php
<?php

use Chubbyphp\ApiHttp\Container\ResponseManagerFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = new ResponseManagerFactory();

$responseManager = $factory($container);
```

## with name `default`

```php
<?php

use Chubbyphp\ApiHttp\Container\ResponseManagerFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = [ResponseManagerFactory::class, 'default'];

$responseManager = $factory($container);
```

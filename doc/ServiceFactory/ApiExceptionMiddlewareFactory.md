# ApiExceptionMiddlewareFactory

## without name (default)

```php
<?php

use Chubbyphp\ApiHttp\ServiceFactory\ApiExceptionMiddlewareFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = new ApiExceptionMiddlewareFactory();

$apiExceptionMiddleware = $factory($container);
```

## with name `default`

```php
<?php

use Chubbyphp\ApiHttp\ServiceFactory\ApiExceptionMiddlewareFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = [ApiExceptionMiddlewareFactory::class, 'default'];

$apiExceptionMiddleware = $factory($container);
```

# RequestManagerFactory

## without name (default)

```php
<?php

use Chubbyphp\ApiHttp\Container\RequestManagerFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = new RequestManagerFactory();

$requestManager = $factory($container);
```

## with name `default`

```php
<?php

use Chubbyphp\ApiHttp\Container\RequestManagerFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = [RequestManagerFactory::class, 'default'];

$requestManager = $factory($container);
```

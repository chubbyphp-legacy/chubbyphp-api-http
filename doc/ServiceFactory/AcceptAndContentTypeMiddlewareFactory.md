# AcceptAndContentTypeMiddlewareFactory

## without name (default)

```php
<?php

use Chubbyphp\ApiHttp\Container\AcceptAndContentTypeMiddlewareFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = new AcceptAndContentTypeMiddlewareFactory();

$acceptAndContentTypeMiddleware = $factory($container);
```

## with name `default`

```php
<?php

use Chubbyphp\ApiHttp\Container\AcceptAndContentTypeMiddlewareFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

$factory = [AcceptAndContentTypeMiddlewareFactory::class, 'default'];

$acceptAndContentTypeMiddleware = $factory($container);
```

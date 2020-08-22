# ApiExceptionMiddlewareFactory

```php
<?php

use Chubbyphp\ApiHttp\Container\ApiExceptionMiddlewareFactory;
use Psr\Container\ContainerInterface;

$factory = new ApiExceptionMiddlewareFactory();

$apiExceptionMiddleware = $factory($container);
```

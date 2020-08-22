# AcceptAndContentTypeMiddlewareFactory

```php
<?php

use Chubbyphp\ApiHttp\Container\AcceptAndContentTypeMiddlewareFactory;
use Psr\Container\ContainerInterface;

$factory = new AcceptAndContentTypeMiddlewareFactory();

$acceptAndContentTypeMiddleware = $factory($container);
```

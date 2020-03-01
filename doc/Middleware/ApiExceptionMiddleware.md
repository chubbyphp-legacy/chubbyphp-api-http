# ApiExceptionMiddleware

```php
<?php

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\ApiExceptionMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/** @var ServerRequestInterface $request */
$request = ...;

/** @var RequestHandlerInterface $handler */
$handler = ...;

/** @var ResponseManagerInterface $responseManager */
$responseManager = ...;

/** @var LoggerInterface $logger */
$logger = ...;

$middleware = new ApiExceptionMiddleware(
    $responseManager,
    true,
    $logger
);

/** @var ResponseInterface $response */
$response = $middleware->process($request, $handler);
```

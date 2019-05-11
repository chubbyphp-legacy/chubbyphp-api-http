# AcceptAndContentTypeMiddleware

```php
<?php

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/** @var ServerRequestInterface $request */
$request = ...;

/** @var RequestHandlerInterface $handler */
$handler = ...;

/** @var AcceptNegotiatorInterface $acceptNegotiator */
$acceptNegotiator = ...;

/** @var ContentTypeNegotiatorInterface $contentTypeNegotiator */
$contentTypeNegotiator = ...;

/** @var ResponseManagerInterface $responseManager */
$responseManager = ...;

$middleware = new AcceptAndContentTypeMiddleware(
    $acceptNegotiator,
    $contentTypeNegotiator,
    $responseManager
);

/** @var ResponseInterface $response */
$response = $middleware->process($request, $handler);
```

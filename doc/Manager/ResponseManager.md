# ResponseManager

```php
<?php

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Serialization\SerializerInterface;

/** @var DeserializerInterface $deserializer */
$deserializer = ...;

/** @var ResponseFactoryInterface $responseFactory */
$responseFactory = ...;

/** @var SerializerInterface $serializer */
$serializer = ...;

$responseManager = new ResponseManager(
    $deserializer,
    $responseFactory,
    $serializer
);

$object = ...;

$response = $responseManager->create(
    $object,
    'application/json'
);

$response = $responseManager->createEmpty(
    'application/json'
);

$response = $responseManager->createRedirect(
    'https://www.google.com'
);

$error = new Error(
    Error::SCOPE_BODY,
    'missing.teapot',
    'there should be a teacup, but its missing'
);

$response = $responseManager->createFromError(
    $error,
    'application/json'
);

$response = $responseManager->createNotAuthenticated(
    'application/json'
);

$response = $responseManager->createNotAuthorized(
    'application/json'
);

$response = $responseManager->createResourceNotFound(
    ['id' => 1],
    'application/json'
);

$response = $responseManager->createAcceptNotSupported(
    'application/json'
);

$response = $responseManager->createContentTypeNotSupported(
    'application/json',
    'application/json'
);
```

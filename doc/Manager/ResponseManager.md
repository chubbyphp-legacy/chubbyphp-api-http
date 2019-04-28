# ResponseManager

```php
<?php

use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;
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

/** @var ApiProblemInterface $apiProblem */
$apiProblem = ...;

$response = $responseManager->createFromApiProblem(
    $apiProblem,
    'application/json'
);
```

# RequestManager

```php
<?php

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/** @var DeserializerInterface $deserializer */
$deserializer = ...;

$requestManager = new RequestManager($deserializer);

/** @var Request $request */
$request = ...;

$object = ...; // class or exiting object with mapping

/** @var DenormalizerContextInterface $context */
$context = ...;

$object = $requestManager->getDataFromRequestQuery($request, $object, $context);
// returns the given object or a instance if a class was given

$object = $requestManager->getDataFromRequestBody($request, $object, 'application/json', $context);
// returns the given object or a instance if a class was given
```

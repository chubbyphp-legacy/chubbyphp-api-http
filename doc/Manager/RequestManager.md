# RequestManager

```php
<?php

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/** @var DeserializerInterface $deserializer */
$deserializer = ...;

/** @var Request $request */
$request = ...;

$object = ...; // class or exiting object with mapping

/** @var DenormalizerContextInterface $context */
$context = ...;

$requestManager = new RequestManager($deserializer);

$object = $requestManager->getDataFromRequestQuery($request, $object, $context);
```

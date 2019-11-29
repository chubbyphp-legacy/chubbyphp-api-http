# ApiHttpServiceFactory

```php
<?php

use Chubbyphp\ApiHttp\ServiceFactory\ApiHttpServiceFactory;
use Chubbyphp\Container\Container;
use Chubbyphp\Deserialization\ServiceFactory\DeserializationServiceFactory;
use Chubbyphp\Serialization\ServiceFactory\SerializationServiceFactory;

$container = new Container();
$container->factories((new ApiHttpServiceFactory())());
$container->factories((new DeserializationServiceFactory())());
$container->factories((new SerializationServiceFactory())());

$container->get('api-http.request.manager')->getDataFromRequestQuery(...);

$container->get('api-http.response.manager')->create(...);

$container->get('api-http.response.factory')->createResponse(...);
// must be defined, implement the ResponseFactoryInterface
```

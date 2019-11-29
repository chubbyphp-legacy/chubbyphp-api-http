# ApiHttpServiceProvider

```php
<?php

use Chubbyphp\ApiHttp\ServiceProvider\ApiHttpServiceProvider;
use Chubbyphp\Deserialization\ServiceProvider\DeserializationServiceProvider;
use Chubbyphp\Serialization\ServiceProvider\SerializationServiceProvider;
use Pimple\Container;

$container = new Container();
$container->register(new DeserializationServiceProvider());
$container->register(new SerializationServiceProvider());
$container->register(new ApiHttpServiceProvider());

$container['api-http.request.manager']->getDataFromRequestQuery(...);

$container['api-http.response.manager']->create(...);

$container['api-http.response.factory']->createResponse(...);
// must be defined, implement the ResponseFactoryInterface
```

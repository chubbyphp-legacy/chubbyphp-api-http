# ErrorMapping

```php
<?php

use Chubbyphp\ApiHttp\Serialization\ErrorMapping;
use Chubbyphp\Serialization\Provider\SerializationProvider;
use Pimple\Container;

$container = new Container();

$container->register(new SerializationProvider());

$container->extend('serializer.normalizer.objectmappings', function (array $mappings) {
    $mappings[] = new ErrorMapping();

    return $mappings;
});
```

# ApiHttpProvider

```php
<?php

use Chubbyphp\ApiHttp\Provider\ApiHttpProvider;
use Pimple\Container;

$container = new Container();
$container->register(new ApiHttpProvider());

$container['api-http.request.manager']->getDataFromRequestQuery(...);

$container['api-http.response.manager']->create(...);

$container['api-http.response.factory']->createResponse(...);
// must be defined, implement the ResponseFactoryInterface
```

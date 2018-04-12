# Error

```php
<?php

use Chubbyphp\ApiHttp\Error\Error;

$error = new Error(
    Error::SCOPE_RESOURCE,
    'resource_not_found',
    'the requested resource cannot be found'
);

echo $error->getScope();
// 'resource'

echo $error->getKey();
// 'resource_not_found'

echo $error->getDetail();
// 'the requested resource cannot be found'

echo $error->getReference();
// null

print_r($error->getArguments());
// []
```

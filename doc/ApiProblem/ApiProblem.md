# ApiProblem

```php
<?php

use Chubbyphp\ApiHttp\ApiProblem\ClientError\BadRequest;

$apiProblem = new BadRequest([
    'name' => 'name',
    'reason' => 'constraint.type.invalidtype',
    'details' => [
        'type' => 'integer',
        'wishedType' => 'string',
    ],
]);
```

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\NotImplemented;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class NotImplementedMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return NotImplemented::class;
    }
}

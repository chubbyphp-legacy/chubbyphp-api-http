<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\FailedDependency;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class FailedDependencyMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return FailedDependency::class;
    }
}

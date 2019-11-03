<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Locked;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class LockedMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return Locked::class;
    }
}

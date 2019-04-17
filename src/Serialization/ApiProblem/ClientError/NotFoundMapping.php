<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotFound;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class NotFoundMapping extends AbstractApiProblemMapping
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return NotFound::class;
    }
}

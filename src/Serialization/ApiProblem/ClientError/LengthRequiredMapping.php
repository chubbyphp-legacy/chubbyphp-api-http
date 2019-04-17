<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\LengthRequired;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class LengthRequiredMapping extends AbstractApiProblemMapping
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return LengthRequired::class;
    }
}

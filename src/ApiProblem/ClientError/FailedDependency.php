<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class FailedDependency extends AbstractApiProblem
{
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 424;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc4918#section-11.4';
    }
}

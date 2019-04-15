<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class InsufficientStorage extends AbstractApiProblem
{
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 507;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc4918#section-11.5';
    }
}

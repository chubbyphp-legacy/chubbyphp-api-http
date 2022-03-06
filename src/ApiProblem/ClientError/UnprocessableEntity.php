<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class UnprocessableEntity extends AbstractApiProblem
{
    /**
     * @param array<int, array<mixed>> $invalidParameters
     */
    public function __construct(private array $invalidParameters, ?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc4918#section-11.2',
            422,
            'Unprocessable Entity',
            $detail,
            $instance
        );
    }

    /**
     * @return array<int, array<mixed>>
     */
    public function getInvalidParameters(): array
    {
        return $this->invalidParameters;
    }
}

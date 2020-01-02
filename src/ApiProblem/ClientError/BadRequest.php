<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class BadRequest extends AbstractApiProblem
{
    /**
     * @var array<int, array>
     */
    private $invalidParameters = [];

    /**
     * @param array<int, array> $invalidParameters
     */
    public function __construct(array $invalidParameters, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.1',
            400,
            'Bad Request',
            $detail,
            $instance
        );

        $this->invalidParameters = $invalidParameters;
    }

    /**
     * @return array<int, array>
     */
    public function getInvalidParameters(): array
    {
        return $this->invalidParameters;
    }
}

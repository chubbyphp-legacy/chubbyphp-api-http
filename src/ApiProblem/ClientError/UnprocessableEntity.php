<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class UnprocessableEntity extends AbstractApiProblem
{
    /**
     * @var array[]
     */
    private $invalidParameters = [];

    /**
     * @param array       $invalidParameters
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $invalidParameters, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc4918#section-11.2',
            422,
            'Unprocessable Entity',
            $detail,
            $instance
        );

        $this->invalidParameters = $invalidParameters;
    }

    /**
     * @return array
     */
    public function getInvalidParameters(): array
    {
        return $this->invalidParameters;
    }
}

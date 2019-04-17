<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class BadRequest extends AbstractApiProblem
{
    /**
     * @var array[]
     */
    private $invalidParameters = [];

    /**
     * @param array       $invalidParameters
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $invalidParameters, string $title, string $detail = null, string $instance = null)
    {
        parent::__construct($title, $detail, $instance);

        $this->invalidParameters = $invalidParameters;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 400;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.1';
    }

    /**
     * @return array
     */
    public function getInvalidParameters(): array
    {
        return $this->invalidParameters;
    }
}

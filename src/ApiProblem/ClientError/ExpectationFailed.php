<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class ExpectationFailed extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $failedExpectations = [];

    /**
     * @param string[]    $failedExpectations
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $failedExpectations, string $title, string $detail = null, string $instance = null)
    {
        parent::__construct($title, $detail, $instance);

        $this->failedExpectations = $failedExpectations;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 417;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.18';
    }

    /**
     * @return string[]
     */
    public function getFailedExpectations(): array
    {
        return $this->failedExpectations;
    }
}

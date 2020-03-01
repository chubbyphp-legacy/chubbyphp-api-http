<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class InternalServerError extends AbstractApiProblem
{
    /**
     * @var array<int, array<mixed>>|null
     */
    private $backtrace;

    public function __construct(?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.5.1',
            500,
            'Internal Server Error',
            $detail,
            $instance
        );
    }

    /**
     * @param array<int, array<mixed>>|null $backtrace
     */
    public function setBacktrace(?array $backtrace): void
    {
        $this->backtrace = $backtrace;
    }

    /**
     * @return array<int, array<mixed>>|null
     */
    public function getBacktrace(): ?array
    {
        return $this->backtrace;
    }
}

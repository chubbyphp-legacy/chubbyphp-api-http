<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class InternalServerError extends AbstractApiProblem
{
    /**
     * @var null|array<int, array<mixed>>
     */
    private ?array $backtrace = null;

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
     * @param null|array<int, array<mixed>> $backtrace
     */
    public function setBacktrace(?array $backtrace): void
    {
        $this->backtrace = $backtrace;
    }

    /**
     * @return null|array<int, array<mixed>>
     */
    public function getBacktrace(): ?array
    {
        return $this->backtrace;
    }
}

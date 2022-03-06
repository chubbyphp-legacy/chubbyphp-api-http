<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class NotAcceptable extends AbstractApiProblem
{
    /**
     * @param array<int, string> $acceptables
     */
    public function __construct(
        private string $accept,
        private array $acceptables,
        ?string $detail = null,
        ?string $instance = null
    ) {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.7',
            406,
            'Not Acceptable',
            $detail,
            $instance
        );
    }

    public function getAccept(): string
    {
        return $this->accept;
    }

    /**
     * @return array<int, string>
     */
    public function getAcceptables(): array
    {
        return $this->acceptables;
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class NotAcceptable extends AbstractApiProblem
{
    private string $accept;

    /**
     * @var array<int, string>
     */
    private array $acceptables = [];

    /**
     * @param array<int, string> $acceptables
     */
    public function __construct(
        string $accept,
        array $acceptables,
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

        $this->accept = $accept;
        $this->acceptables = $acceptables;
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

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class NotAcceptable extends AbstractApiProblem
{
    /**
     * @var string
     */
    private $accept;

    /**
     * @var string[]
     */
    private $acceptables = [];

    /**
     * @param string      $accept
     * @param string[]    $acceptables
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(
        string $accept,
        array $acceptables,
        string $detail = null,
        string $instance = null
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

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        if ([] === $this->acceptables) {
            return [];
        }

        return ['X-Acceptables' => implode(',', $this->acceptables)];
    }

    /**
     * @return string
     */
    public function getAccept(): string
    {
        return $this->accept;
    }

    /**
     * @return string[]
     */
    public function getAcceptables(): array
    {
        return $this->acceptables;
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class MethodNotAllowed extends AbstractApiProblem
{
    /**
     * @param string             $method,
     * @param array<int, string> $allowedMethods
     */
    public function __construct(
        private string $method,
        private array $allowedMethods,
        ?string $detail = null,
        ?string $instance = null
    ) {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.6',
            405,
            'Method Not Allowed',
            $detail,
            $instance
        );
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return ['Allow' => implode(',', $this->allowedMethods)];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array<int, string>
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}

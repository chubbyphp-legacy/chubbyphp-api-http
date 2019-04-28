<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class MethodNotAllowed extends AbstractApiProblem
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string[]
     */
    private $allowedMethods = [];

    /**
     * @param string      $method,
     * @param string[]    $allowedMethods
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(string $method, array $allowedMethods, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.6',
            405,
            'Method Not Allowed',
            $detail,
            $instance
        );

        $this->method = $method;
        $this->allowedMethods = $allowedMethods;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return ['Allow' => implode(',', $this->allowedMethods)];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string[]
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}

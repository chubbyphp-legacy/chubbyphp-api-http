<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class MethodNotAllowed extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $allowedMethods = [];

    /**
     * @param string[]    $allowedMethods
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $allowedMethods, string $title, string $detail = null, string $instance = null)
    {
        parent::__construct($title, $detail, $instance);

        $this->allowedMethods = $allowedMethods;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 405;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        if ([] === $this->allowedMethods) {
            return [];
        }

        return ['Allow' => implode(',', $this->allowedMethods)];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.6';
    }

    /**
     * @return string[]
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}

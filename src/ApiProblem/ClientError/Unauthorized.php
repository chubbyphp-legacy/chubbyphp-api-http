<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class Unauthorized extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $authorizationTypes = [];

    /**
     * @param string[]    $authorizationTypes
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $authorizationTypes, string $title, string $detail = null, string $instance = null)
    {
        parent::__construct($title, $detail, $instance);

        $this->authorizationTypes = $authorizationTypes;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 401;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        if ([] === $this->authorizationTypes) {
            return [];
        }

        return ['WWW-Authenticate' => implode(',', $this->authorizationTypes)];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.2';
    }

    /**
     * @return string[]
     */
    public function getAuthorizationTypes(): array
    {
        return $this->authorizationTypes;
    }
}

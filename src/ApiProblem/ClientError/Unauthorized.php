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
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $authorizationTypes, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.2',
            401,
            'Unauthorized',
            $detail,
            $instance
        );

        $this->authorizationTypes = $authorizationTypes;
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
     * @return string[]
     */
    public function getAuthorizationTypes(): array
    {
        return $this->authorizationTypes;
    }
}

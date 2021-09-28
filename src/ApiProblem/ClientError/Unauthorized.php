<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class Unauthorized extends AbstractApiProblem
{
    private string $authorization;

    /**
     * @var array<int, string>
     */
    private array $authorizationTypes = [];

    /**
     * @param array<int, string> $authorizationTypes
     */
    public function __construct(
        string $authorization,
        array $authorizationTypes,
        ?string $detail = null,
        ?string $instance = null
    ) {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.2',
            401,
            'Unauthorized',
            $detail,
            $instance
        );

        $this->authorization = $authorization;
        $this->authorizationTypes = $authorizationTypes;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return ['WWW-Authenticate' => implode(',', $this->authorizationTypes)];
    }

    public function getAuthorization(): string
    {
        return $this->authorization;
    }

    /**
     * @return array<int, string>
     */
    public function getAuthorizationTypes(): array
    {
        return $this->authorizationTypes;
    }
}

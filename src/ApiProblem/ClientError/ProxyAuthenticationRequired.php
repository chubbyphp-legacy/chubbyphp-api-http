<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class ProxyAuthenticationRequired extends AbstractApiProblem
{
    /**
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.8',
            407,
            'Proxy Authentication Required',
            $detail,
            $instance
        );
    }
}

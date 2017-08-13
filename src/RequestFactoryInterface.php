<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp;

use Psr\Http\Message\ResponseInterface as Response;

interface ResponseFactoryInterface
{
    /**
     * @param int $code
     *
     * @return Response
     */
    public function createResponse($code = 200): Response;
}

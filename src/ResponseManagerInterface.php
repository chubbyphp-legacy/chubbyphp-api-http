<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface ResponseManagerInterface
{
    /**
     * @param Request $request
     * @param int     $code
     * @param object  $object
     *
     * @return Response
     */
    public function createResponse(Request $request, int $code, $object = null): Response;
}

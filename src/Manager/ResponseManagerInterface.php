<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface ResponseManagerInterface
{
    /**
     * @param Request     $request
     * @param int         $code
     * @param object      $object
     * @param string|null $defaultAccept
     *
     * @return Response
     */
    public function createResponse(
        Request $request,
        int $code = 200,
        $object = null,
        string $defaultAccept = null
    ): Response;
}

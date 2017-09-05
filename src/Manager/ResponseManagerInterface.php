<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\Error;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface ResponseManagerInterface
{
    /**
     * @param Request $request
     * @param int     $code
     * @param object  $object
     * @param string  $accept
     *
     * @return Response
     */
    public function createResponse(Request $request, int $code, $object, string $accept): Response;

    /**
     * @param Request $request
     * @param int     $code
     * @param Error   $error
     * @param string  $accept
     *
     * @return Response
     */
    public function createResponseByError(Request $request, int $code, Error $error, string $accept): Response;

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createAcceptNotSupportedResponse(Request $request): Response;

    /**
     * @param Request $request
     * @param string  $accept
     *
     * @return Response
     */
    public function createContentTypeNotSupportedResponse(Request $request, string $accept): Response;

    /**
     * @param Request $request
     * @param string  $accept
     * @param string  $contentType
     *
     * @return Response
     */
    public function createBodyNotDeserializableResponse(
        Request $request,
        string $accept,
        string $contentType
    ): Response;

    /**
     * @param Request $request
     * @param string  $accept
     * @param string  $scope
     * @param string  $type
     * @param array   $errors
     *
     * @return Response
     */
    public function createValidationErrorResponse(
        Request $request,
        string $accept,
        string $scope,
        string $type,
        array $errors
    ): Response;
}

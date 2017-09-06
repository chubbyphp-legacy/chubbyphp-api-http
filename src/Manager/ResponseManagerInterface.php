<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface ResponseManagerInterface
{
    /**
     * @param Request     $request
     * @param int         $code
     * @param string      $accept
     * @param object|null $object
     *
     * @return Response
     */
    public function createResponse(Request $request, int $code, string $accept, $object = null): Response;

    /**
     * @param Request        $request
     * @param int            $code
     * @param string         $accept
     * @param ErrorInterface $error
     *
     * @return Response
     */
    public function createResponseByError(Request $request, int $code, string $accept, ErrorInterface $error): Response;

    /**
     * @param Request $request
     * @param string  $accept
     * @param string  $contentType
     *
     * @return Response
     */
    public function createBodyNotDeserializableResponse(Request $request, string $accept, string $contentType): Response;

    /**
     * @param Request $request
     * @param string  $accept
     * @param string  $type
     * @param array   $arguments
     *
     * @return Response
     */
    public function createPermissionDeniedResponse(
        Request $request,
        string $accept,
        string $type,
        array $arguments
    ): Response;

    /**
     * @param Request $request
     * @param string  $accept
     * @param string  $type
     * @param array   $arguments
     *
     * @return Response
     */
    public function createResourceNotFoundResponse(
        Request $request,
        string $accept,
        string $type,
        array $arguments
    ): Response;

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

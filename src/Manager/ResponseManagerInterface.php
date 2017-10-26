<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContext;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface ResponseManagerInterface
{
    /**
     * @param object|null            $object
     * @param string                 $accept
     * @param int                    $status
     * @param NormalizerContext|null $context
     * @return Response
     */
    public function create(
        $object,
        string $accept,
        int $status = 200,
        NormalizerContext $context = null
    ): Response;

    /**
     * @param string $url
     * @param int    $code
     * @return Response
     */
    public function createRedirect(string $url, int $code = 307): Response;

    /**
     * @param ErrorInterface         $error
     * @param string                 $accept
     * @param int                    $status
     * @param NormalizerContext|null $context
     * @return Response
     */
    public function createByError(
        ErrorInterface $error,
        string $accept,
        int $status = 400,
        NormalizerContext $context = null
    ): Response;

    /**
     * @param string                 $type
     * @param array                  $arguments
     * @param string                 $accept
     * @param NormalizerContext|null $context
     * @return Response
     */
    public function createNotAuthenticated(
        string $type,
        array $arguments,
        string $accept,
        NormalizerContext $context = null
    ): Response;

    /**
     * @param string                 $type
     * @param array                  $arguments
     * @param string                 $accept
     * @param NormalizerContext|null $context
     * @return Response
     */
    public function createNotAuthorized(
        string $type,
        array $arguments,
        string $accept,
        NormalizerContext $context = null
    ): Response;

    /**
     * @param string                 $type
     * @param array                  $arguments
     * @param string                 $accept
     * @param NormalizerContext|null $context
     * @return Response
     */
    public function createResourceNotFound(
        string $type,
        array $arguments,
        string $accept,
        NormalizerContext $context = null
    ): Response;

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createAcceptNotSupported(Request $request): Response;

    /**
     * @param Request                $request
     * @param string                 $accept
     * @param array                  $supportedContentTypes
     * @param NormalizerContext|null $context
     * @return Response
     */
    public function createContentTypeNotSupported(
        Request $request,
        string $accept,
        array $supportedContentTypes,
        NormalizerContext $context = null
    ): Response;
}

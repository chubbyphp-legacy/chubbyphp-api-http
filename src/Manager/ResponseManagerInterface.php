<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Psr\Http\Message\ResponseInterface as Response;

interface ResponseManagerInterface
{
    /**
     * @param object                          $object
     * @param string                          $accept
     * @param int                             $status
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function create(
        $object,
        string $accept,
        int $status = 200,
        NormalizerContextInterface $context = null
    ): Response;

    /**
     * @param string $accept
     * @param int    $status
     *
     * @return Response
     */
    public function createEmpty(string $accept, int $status = 204): Response;

    /**
     * @param string $location
     * @param int    $status
     *
     * @return Response
     */
    public function createRedirect(string $location, int $status = 307): Response;

    /**
     * @param ErrorInterface                  $error
     * @param string                          $accept
     * @param int                             $status
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createFromError(
        ErrorInterface $error,
        string $accept,
        int $status = 400,
        NormalizerContextInterface $context = null
    ): Response;

    /**
     * @param string                          $accept
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createNotAuthenticated(string $accept, NormalizerContextInterface $context = null): Response;

    /**
     * @param string                          $accept
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createNotAuthorized(string $accept, NormalizerContextInterface $context = null): Response;

    /**
     * @param string                          $type
     * @param array                           $arguments
     * @param string                          $accept
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createResourceNotFound(
        string $type,
        array $arguments,
        string $accept,
        NormalizerContextInterface $context = null
    ): Response;

    /**
     * @param string $accept
     *
     * @return Response
     */
    public function createAcceptNotSupported(string $accept): Response;

    /**
     * @param string                          $contentType
     * @param string                          $accept
     * @param array                           $supportedContentTypes
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createContentTypeNotSupported(
        string $contentType,
        string $accept,
        array $supportedContentTypes,
        NormalizerContextInterface $context = null
    ): Response;
}

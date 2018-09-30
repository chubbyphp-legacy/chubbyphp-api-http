<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface as LegacyResponseFactoryInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Chubbyphp\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var DeserializerInterface
     */
    private $deserializer;

    /**
     * @var LegacyResponseFactoryInterface|ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param DeserializerInterface                                   $deserializer
     * @param LegacyResponseFactoryInterface|ResponseFactoryInterface $responseFactory
     * @param SerializerInterface                                     $serializer
     */
    public function __construct(
        DeserializerInterface $deserializer,
        $responseFactory,
        SerializerInterface $serializer
    ) {
        if (!$responseFactory instanceof ResponseFactoryInterface
            && !$responseFactory instanceof LegacyResponseFactoryInterface
        ) {
            throw new \TypeError(
                sprintf(
                    '%s::__construct() expects parameter 1 to be %s|%s, %s given',
                    self::class,
                    ResponseFactoryInterface::class,
                    LegacyResponseFactoryInterface::class,
                    is_object($responseFactory) ? get_class($responseFactory) : gettype($responseFactory)
                )
            );
        }

        if ($responseFactory instanceof LegacyResponseFactoryInterface) {
            @trigger_error(
                sprintf(
                    'Use "%s" instead of "%s" as __construct argument',
                    ResponseFactoryInterface::class,
                    LegacyResponseFactoryInterface::class
                ),
                E_USER_DEPRECATED
            );
        }

        $this->deserializer = $deserializer;
        $this->responseFactory = $responseFactory;
        $this->serializer = $serializer;
    }

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
    ): Response {
        $body = $this->serializer->serialize($object, $accept, $context);

        $response = $this->responseFactory->createResponse($status)->withHeader('Content-Type', $accept);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param string $accept
     * @param int    $status
     *
     * @return Response
     */
    public function createEmpty(string $accept, int $status = 204): Response
    {
        return $this->responseFactory->createResponse($status)->withHeader('Content-Type', $accept);
    }

    /**
     * @param string $location
     * @param int    $status
     *
     * @return Response
     */
    public function createRedirect(string $location, int $status = 307): Response
    {
        return $this->responseFactory->createResponse($status)->withHeader('Location', $location);
    }

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
    ): Response {
        return $this->create($error, $accept, $status, $context);
    }

    /**
     * @param string                          $accept
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createNotAuthenticated(string $accept, NormalizerContextInterface $context = null): Response
    {
        return $this->createFromError(new Error(
            Error::SCOPE_HEADER,
            'not_authenticated',
            'missing or invalid authentication token to perform the request'
        ), $accept, 401, $context);
    }

    /**
     * @param string                          $accept
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createNotAuthorized(string $accept, NormalizerContextInterface $context = null): Response
    {
        return $this->createFromError(new Error(
            Error::SCOPE_HEADER,
            'permission_denied',
            'missing authorization to perform request'
        ), $accept, 403, $context);
    }

    /**
     * @param array                           $arguments
     * @param string                          $accept
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createResourceNotFound(
        array $arguments,
        string $accept,
        NormalizerContextInterface $context = null
    ): Response {
        return $this->createFromError(new Error(
            Error::SCOPE_RESOURCE,
            'resource_not_found',
            'the requested resource cannot be found',
            null,
            $arguments
        ), $accept, 404, $context);
    }

    /**
     * @param string $accept
     *
     * @return Response
     */
    public function createAcceptNotSupported(string $accept): Response
    {
        return $this->responseFactory->createResponse(406)->withHeader('X-Not-Acceptable', sprintf(
            'Accept "%s" is not supported, supported are %s',
            $accept,
            '"'.implode('", "', $this->serializer->getContentTypes()).'"'
        ));
    }

    /**
     * @param string                          $contentType
     * @param string                          $accept
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function createContentTypeNotSupported(
        string $contentType,
        string $accept,
        NormalizerContextInterface $context = null
    ): Response {
        return $this->createFromError(new Error(
            Error::SCOPE_HEADER,
            'contentype_not_supported',
            'the given content type is not supported',
            null,
            [
                'contentType' => $contentType,
                'supportedContentTypes' => $this->deserializer->getContentTypes(),
            ]
        ), $accept, 415, $context);
    }
}

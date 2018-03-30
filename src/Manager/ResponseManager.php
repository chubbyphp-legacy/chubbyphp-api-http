<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContext;
use Chubbyphp\Serialization\SerializerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var DeserializerInterface
     */
    private $deserializer;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param DeserializerInterface    $deserializer
     * @param SerializerInterface      $serializer
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        DeserializerInterface $deserializer,
        SerializerInterface $serializer
    ) {
        $this->responseFactory = $responseFactory;
        $this->deserializer = $deserializer;
        $this->serializer = $serializer;
    }

    /**
     * @param object                 $object
     * @param string                 $accept
     * @param int                    $status
     * @param NormalizerContext|null $context
     *
     * @return Response
     */
    public function create(
        $object,
        string $accept,
        int $status = 200,
        NormalizerContext $context = null
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
        return $this->responseFactory->createResponse($status)->withAddedHeader('Location', $location);
    }

    /**
     * @param ErrorInterface         $error
     * @param string                 $accept
     * @param int                    $status
     * @param NormalizerContext|null $context
     *
     * @return Response
     */
    public function createByError(
        ErrorInterface $error,
        string $accept,
        int $status = 400,
        NormalizerContext $context = null
    ): Response {
        return $this->create($error, $accept, $status, $context);
    }

    /**
     * @param Request                $request
     * @param string                 $accept
     * @param string                 $authenticationType
     * @param string                 $reason
     * @param NormalizerContext|null $context
     *
     * @return Response
     */
    public function createNotAuthenticated(
        Request $request,
        string $accept,
        string $authenticationType,
        string $reason,
        NormalizerContext $context = null
    ): Response {
        return $this->createByError(new Error(
            Error::SCOPE_HEADER,
            'not_authenticated',
            'missing or invalid authentication token',
            'authentication',
            [
                'type' => $authenticationType,
                'value' => $request->getHeaderLine('Authorization'),
                'reason' => $reason,
            ]
        ), $accept, 401, $context);
    }

    /**
     * @param string                 $type
     * @param array                  $arguments
     * @param string                 $accept
     * @param NormalizerContext|null $context
     *
     * @return Response
     */
    public function createNotAuthorized(
        string $type,
        array $arguments,
        string $accept,
        NormalizerContext $context = null
    ): Response {
        return $this->createByError(new Error(
            Error::SCOPE_HEADER,
            'permission_denied',
            'authenticated client/user is not allowed to perform this action',
            $type,
            $arguments
        ), $accept, 403, $context);
    }

    /**
     * @param string                 $type
     * @param array                  $arguments
     * @param string                 $accept
     * @param NormalizerContext|null $context
     *
     * @return Response
     */
    public function createResourceNotFound(
        string $type,
        array $arguments,
        string $accept,
        NormalizerContext $context = null
    ): Response {
        return $this->createByError(new Error(
            Error::SCOPE_RESOURCE,
            'resource_not_found',
            'the requested resource cannot be found',
            $type,
            $arguments
        ), $accept, 404, $context);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createAcceptNotSupported(Request $request): Response
    {
        return $this->responseFactory->createResponse(406)->withHeader('X-Not-Acceptable', sprintf(
            'Accept "%s" is not supported, supported are %s',
            $request->getHeaderLine('Accept'),
            implode(', ', $this->serializer->getContentTypes())
        ));
    }

    /**
     * @param Request                $request
     * @param string                 $accept
     * @param array                  $supportedContentTypes
     * @param NormalizerContext|null $context
     *
     * @return Response
     */
    public function createContentTypeNotSupported(
        Request $request,
        string $accept,
        array $supportedContentTypes,
        NormalizerContext $context = null
    ): Response {
        return $this->createByError(new Error(
            Error::SCOPE_HEADER,
            'contentype_not_supported',
            'the given content type is not supported',
            'content-type',
            [
                'contentType' => $request->getHeaderLine('Content-Type'),
                'supportedContentTypes' => $this->deserializer->getContentTypes(),
            ]
        ), $accept, 415, $context);
    }
}

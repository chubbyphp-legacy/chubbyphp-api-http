<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\Serialization\SerializerInterface;
use Chubbyphp\Serialization\TransformerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var RequestManagerInterface
     */
    private $requestManager;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * @param RequestManagerInterface  $requestManager
     * @param ResponseFactoryInterface $responseFactory
     * @param SerializerInterface      $serializer
     * @param TransformerInterface     $transformer
     */
    public function __construct(
        RequestManagerInterface $requestManager,
        ResponseFactoryInterface $responseFactory,
        SerializerInterface $serializer,
        TransformerInterface $transformer
    ) {
        $this->requestManager = $requestManager;
        $this->responseFactory = $responseFactory;
        $this->serializer = $serializer;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     * @param int     $code
     * @param string  $accept
     * @param object|null  $object
     *
     * @return Response
     */
    public function createResponse(Request $request, int $code, string $accept, $object = null): Response
    {
        $response = $this->responseFactory->createResponse($code);

        if (null === $object) {
            if (200 === $code) {
                return $response->withStatus(204);
            }

            return $response;
        }

        $body = $this->transformer->transform($this->serializer->serialize($request, $object), $accept);

        $response = $response->withStatus($code)->withHeader('Content-Type', $accept);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param Request $request
     * @param int     $code
     * @param string  $accept
     * @param Error   $error
     *
     * @return Response
     */
    public function createResponseByError(Request $request, int $code, string $accept, Error $error): Response
    {
        $response = $this->responseFactory->createResponse($code);

        $body = $this->transformer->transform($this->serializer->serialize($request, $error), $accept);

        $response = $response->withStatus($code)->withHeader('Content-Type', $accept);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createAcceptNotSupportedResponse(Request $request): Response
    {
        $response = $this->responseFactory->createResponse(406);
        $response = $response->withHeader('X-Not-Acceptable', sprintf(
            'Accept "%s" is not supported, supported are %s',
            $request->getHeaderLine('Accept'),
            implode(', ', $this->requestManager->getSupportedAccepts())
        ));

        return $response;
    }

    /**
     * @param Request $request
     * @param string  $accept
     *
     * @return Response
     */
    public function createContentTypeNotSupportedResponse(Request $request, string $accept): Response
    {
        return $this->createResponseByError($request, 415, $accept, new Error(
            Error::SCOPE_HEADER,
            'contentype_not_supported',
            'the given content type is not supported',
            'content-type',
            [
                'contentType' => $request->getHeaderLine('Content-Type'),
                'supportedContentTypes' => $this->requestManager->getSupportedContentTypes(),
            ]
        ));
    }

    /**
     * @param Request $request
     * @param string  $accept
     * @param string  $contentType
     *
     * @return Response
     */
    public function createBodyNotDeserializableResponse(Request $request, string $accept, string $contentType): Response
    {
        return $this->createResponseByError($request, 400, $accept, new Error(
            Error::SCOPE_BODY,
            'body_not_parsable',
            'the given body is not parsable with given content-type',
            'deserialize',
            [
                'contentType' => $contentType,
                'body' => (string) $request->getBody(),
            ]
        ));
    }

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
    ): Response {
        return $this->createResponseByError($request, 422, $accept, new Error(
            $scope,
            'validation_error',
            'there where validation errors while validating the object',
            $type,
            $errors
        ));
    }

    /**
     * @param Request $request
     * @param string $accept
     * @param string $type
     * @param array $arguments
     * @return Response
     */
    public function createResourceNotFoundResponse(
        Request $request,
        string $accept,
        string $type,
        array $arguments
    ): Response {
        return $this->createResponseByError($request, 404, $accept, new Error(
            Error::SCOPE_RESOURCE,
            'resource_not_found',
            'the wished resource does not exist',
            $type, $arguments
        ));
    }
}

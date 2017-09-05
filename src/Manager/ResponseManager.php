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
     * @param object  $object
     * @param string  $accept
     *
     * @return Response
     */
    public function createResponse(Request $request, int $code, $object, string $accept): Response
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
     * @param Error   $error
     * @param string  $accept
     *
     * @return Response
     */
    public function createResponseByError(Request $request, int $code, Error $error, string $accept): Response
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
        $response->withHeader('X-Not-Acceptable', sprintf(
            'Accept "%" is not supported, supported are %s',
            $request->getHeaderLine('Accept'),
            $this->requestManager->getSupportedAccepts()
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
        return $this->createResponseByError($request, 415, new Error(
            Error::SCOPE_HEADER,
            'contentype_not_supported',
            'the given content type is not supported',
            'content-type',
            [
                'contentType' => $request->getHeaderLine('Content-Type'),
                'supportedContentTypes' => $this->requestManager->getSupportedContentTypes(),
            ]
        ), $accept);
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
        return $this->createResponseByError($request, 400, new Error(
            Error::SCOPE_BODY,
            'body_not_parsable',
            'the given body is not parsable with given content-type',
            'deserialize',
            [
                'contentType' => $contentType,
                'body' => (string) $request->getBody(),
            ]
        ), $accept);
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
        return $this->createResponseByError($request, 422, new Error(
            $scope,
            'validation_error',
            'there where validation errors while validating the model',
            $type,
            $errors
        ), $accept);
    }

    /**
     * @param string $type
     * @param string $contentType
     * @param string $body
     *
     * @return Error
     */
    public function createNotReadable(string $type, string $contentType, string $body): Error
    {
        return new Error(
            Error::SCOPE_BODY,
            'bodynotreadable',
            'request body not parsable',
            $type,
            ['body' => $body, 'contentType' => $contentType]
         );
    }
}

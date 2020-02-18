<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;
use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable;
use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddlewareResponseFactoryInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Chubbyphp\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseManager implements ResponseManagerInterface, AcceptAndContentTypeMiddlewareResponseFactoryInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct()
    {
        $args = func_get_args();

        if ($args[0] instanceof DeserializerInterface) {
            @trigger_error(
                'Remove deserializer as first argument.',
                E_USER_DEPRECATED
            );

            array_shift($args);
        }

        $this->setResponseFactory($args[0]);
        $this->setSerializer($args[1]);
    }

    /**
     * @param object $object
     * @param string $accept
     * @param int $status
     * @param NormalizerContextInterface|null $context
     * @return ResponseInterface
     */
    public function create(
        $object,
        string $accept,
        int $status = 200,
        ?NormalizerContextInterface $context = null
    ): ResponseInterface {
        $body = $this->serializer->serialize($object, $accept, $context);

        $response = $this->responseFactory->createResponse($status)->withHeader('Content-Type', $accept);
        $response->getBody()->write($body);

        return $response;
    }

    public function createEmpty(string $accept, int $status = 204): ResponseInterface
    {
        return $this->responseFactory->createResponse($status)->withHeader('Content-Type', $accept);
    }

    public function createRedirect(string $location, int $status = 307): ResponseInterface
    {
        return $this->responseFactory->createResponse($status)->withHeader('Location', $location);
    }

    public function createFromApiProblem(
        ApiProblemInterface $apiProblem,
        string $accept,
        ?NormalizerContextInterface $context = null
    ): ResponseInterface {
        $status = $apiProblem->getStatus();

        $response = $this->responseFactory->createResponse($status)
            ->withHeader('Content-Type', str_replace('/', '/problem+', $accept))
        ;

        foreach ($apiProblem->getHeaders() as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        $body = $this->serializer->serialize($apiProblem, $accept, $context);

        $response->getBody()->write($body);

        return $response;
    }

    private function setResponseFactory(ResponseFactoryInterface $responseFactory): void
    {
        $this->responseFactory = $responseFactory;
    }

    private function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    public function createForNotAcceptable(
        string $accept,
        array $acceptableMimeTypes,
        string $mimeType
    ): ResponseInterface {
        return $this->createFromApiProblem(new NotAcceptable($accept, $acceptableMimeTypes), $mimeType);
    }

    public function createForUnsupportedMediaType(
        string $mediaType,
        array $supportedMediaTypes,
        string $mimeType
    ): ResponseInterface {
        return $this->createFromApiProblem(new UnsupportedMediaType($mediaType, $supportedMediaTypes), $mimeType);
    }
}

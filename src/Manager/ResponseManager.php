<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Chubbyphp\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ResponseFactoryInterface $responseFactory, SerializerInterface $serializer)
    {
        $this->responseFactory = $responseFactory;
        $this->serializer = $serializer;
    }

    /**
     * @param object $object
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
}

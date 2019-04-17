<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Chubbyphp\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var DeserializerInterface
     */
    private $deserializer;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param DeserializerInterface    $deserializer
     * @param ResponseFactoryInterface $responseFactory
     * @param SerializerInterface      $serializer
     */
    public function __construct(
        DeserializerInterface $deserializer,
        ResponseFactoryInterface $responseFactory,
        SerializerInterface $serializer
    ) {
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
     * @param ApiProblemInterface        $apiProblem
     * @param string                     $accept
     * @param NormalizerContextInterface $context
     *
     * @return Response
     */
    public function createFromApiProblem(
        ApiProblemInterface $apiProblem,
        string $accept,
        NormalizerContextInterface $context = null
    ): Response {
        $status = $apiProblem->getStatus();

        $response = $this->responseFactory->createResponse($status);

        foreach ($apiProblem->getHeaders() as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        if (406 === $status) {
            return $response;
        }

        $response = $response->withHeader('Content-Type', $accept);

        $body = $this->serializer->serialize($apiProblem, $accept, $context);

        $response->getBody()->write($body);

        return $response;
    }
}

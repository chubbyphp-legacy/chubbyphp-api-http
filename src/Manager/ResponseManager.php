<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\HttpException\HttpExceptionInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Chubbyphp\Serialization\SerializerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseManager implements ResponseManagerInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private SerializerInterface $serializer
    ) {}

    public function create(
        object $object,
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

    public function createFromHttpException(
        HttpExceptionInterface $httpException,
        string $accept,
    ): ResponseInterface {
        $status = $httpException->getStatus();

        $response = $this->responseFactory->createResponse($status)
            ->withHeader('Content-Type', str_replace('/', '/problem+', $accept))
        ;

        $data = $httpException->jsonSerialize();
        $data['_type'] = 'apiProblem';

        $body = $this->serializer->encode($data, $accept);

        $response->getBody()->write($body);

        return $response;
    }
}

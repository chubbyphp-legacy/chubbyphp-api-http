<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

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
     * @param Request     $request
     * @param int         $code
     * @param object      $object
     * @param string|null $defaultAccept
     *
     * @return Response
     */
    public function createResponse(
        Request $request,
        int $code = 200,
        $object = null,
        string $defaultAccept = null
    ): Response {
        $response = $this->responseFactory->createResponse($code);

        if (null === $object) {
            if (200 === $code) {
                return $response->withStatus(204);
            }

            return $response;
        }

        if (null === $accept = $this->requestManager->getAccept($request, $defaultAccept)) {
            return $response->withStatus(406);
        }

        $body = $this->transformer->transform($this->serializer->serialize($request, $object), $accept);

        /** @var Response $response */
        $response = $response->withStatus($code)->withHeader('Content-Type', $accept);
        $response->getBody()->write($body);

        return $response;
    }
}

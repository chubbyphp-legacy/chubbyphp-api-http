<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Middleware;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable;
use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AcceptAndContentTypeMiddleware implements MiddlewareInterface
{
    private AcceptNegotiatorInterface $acceptNegotiator;

    private ContentTypeNegotiatorInterface $contentTypeNegotiator;

    private ResponseManagerInterface $responseManager;

    public function __construct(
        AcceptNegotiatorInterface $acceptNegotiator,
        ContentTypeNegotiatorInterface $contentTypeNegotiator,
        ResponseManagerInterface $responseManager
    ) {
        $this->acceptNegotiator = $acceptNegotiator;
        $this->contentTypeNegotiator = $contentTypeNegotiator;
        $this->responseManager = $responseManager;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (null === $accept = $this->acceptNegotiator->negotiate($request)) {
            $supportedMediaTypes = $this->acceptNegotiator->getSupportedMediaTypes();

            return $this->responseManager->createFromApiProblem(
                new NotAcceptable(
                    $request->getHeaderLine('Accept'),
                    $supportedMediaTypes
                ),
                $supportedMediaTypes[0]
            );
        }

        $request = $request->withAttribute('accept', $accept->getValue());

        if (\in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true)) {
            if (null === $contentType = $this->contentTypeNegotiator->negotiate($request)) {
                return $this->responseManager->createFromApiProblem(
                    new UnsupportedMediaType(
                        $request->getHeaderLine('Content-Type'),
                        $this->contentTypeNegotiator->getSupportedMediaTypes()
                    ),
                    $accept->getValue()
                );
            }

            $request = $request->withAttribute('contentType', $contentType->getValue());
        }

        return $handler->handle($request);
    }
}

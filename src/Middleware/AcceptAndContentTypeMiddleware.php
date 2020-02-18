<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Middleware;

use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AcceptAndContentTypeMiddleware implements MiddlewareInterface
{
    /**
     * @var AcceptNegotiatorInterface
     */
    private $acceptNegotiator;

    /**
     * @var ContentTypeNegotiatorInterface
     */
    private $contentTypeNegotiator;

    /**
     * @var AcceptAndContentTypeMiddlewareResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(
        AcceptNegotiatorInterface $acceptNegotiator,
        ContentTypeNegotiatorInterface $contentTypeNegotiator,
        AcceptAndContentTypeMiddlewareResponseFactoryInterface $responseFactory
    ) {
        $this->acceptNegotiator = $acceptNegotiator;
        $this->contentTypeNegotiator = $contentTypeNegotiator;
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (null === $accept = $this->acceptNegotiator->negotiate($request)) {
            $supportedMediaTypes = $this->acceptNegotiator->getSupportedMediaTypes();

            return $this->responseFactory->createForNotAcceptable(
                $request->getHeaderLine('Accept'),
                $supportedMediaTypes,
                $supportedMediaTypes[0]
            );
        }

        $request = $request->withAttribute('accept', $accept->getValue());

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true)) {
            if (null === $contentType = $this->contentTypeNegotiator->negotiate($request)) {
                return $this->responseFactory->createForUnsupportedMediaType(
                    $request->getHeaderLine('Content-Type'),
                    $this->contentTypeNegotiator->getSupportedMediaTypes(),
                    $accept->getValue()
                );
            }

            $request = $request->withAttribute('contentType', $contentType->getValue());
        }

        return $handler->handle($request);
    }
}

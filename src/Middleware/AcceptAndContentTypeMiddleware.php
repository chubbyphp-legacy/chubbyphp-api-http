<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Middleware;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\HttpException\HttpException;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AcceptAndContentTypeMiddleware implements MiddlewareInterface
{
    public function __construct(
        private AcceptNegotiatorInterface $acceptNegotiator,
        private ContentTypeNegotiatorInterface $contentTypeNegotiator,
        private ResponseManagerInterface $responseManager
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (null === $accept = $this->acceptNegotiator->negotiate($request)) {
            $supportedMediaTypes = $this->acceptNegotiator->getSupportedMediaTypes();

            return $this->responseManager->createFromHttpException(
                HttpException::createNotAcceptable([
                    'accept' => $request->getHeaderLine('Accept'),
                    'supported-accepts' => $supportedMediaTypes,
                ]),
                $supportedMediaTypes[0],
            );
        }

        $request = $request->withAttribute('accept', $accept->getValue());

        if (\in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true)) {
            if (null === $contentType = $this->contentTypeNegotiator->negotiate($request)) {
                return $this->responseManager->createFromHttpException(
                    HttpException::createUnsupportedMediaType([
                        'content-type' => $request->getHeaderLine('Content-Type'),
                        'supported-content-types' => $this->contentTypeNegotiator->getSupportedMediaTypes(),
                    ]),
                    $accept->getValue(),
                );
            }

            $request = $request->withAttribute('contentType', $contentType->getValue());
        }

        return $handler->handle($request);
    }
}

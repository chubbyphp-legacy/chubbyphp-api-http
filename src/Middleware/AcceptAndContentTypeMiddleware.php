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
            $supportedAccepts = $this->acceptNegotiator->getSupportedMediaTypes();

            return $this->responseManager->createFromHttpException(
                HttpException::createNotAcceptable([
                    'accept' => $request->getHeaderLine('Accept'),
                    'supportedAccepts' => $supportedAccepts,
                ]),
                $supportedAccepts[0],
            );
        }

        $request = $request->withAttribute('accept', $accept->getValue());

        if (\in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true)) {
            if (null === $contentType = $this->contentTypeNegotiator->negotiate($request)) {
                return $this->responseManager->createFromHttpException(
                    HttpException::createUnsupportedMediaType([
                        'contentType' => $request->getHeaderLine('Content-Type'),
                        'supportedContentTypes' => $this->contentTypeNegotiator->getSupportedMediaTypes(),
                    ]),
                    $accept->getValue(),
                );
            }

            $request = $request->withAttribute('contentType', $contentType->getValue());
        }

        return $handler->handle($request);
    }
}

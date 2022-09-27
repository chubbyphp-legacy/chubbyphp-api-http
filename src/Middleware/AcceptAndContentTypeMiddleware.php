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
            $supportedValues = $this->acceptNegotiator->getSupportedMediaTypes();

            return $this->responseManager->createFromHttpException(
                HttpException::createNotAcceptable(
                    $this->aggregateData(
                        'accept',
                        $request->getHeaderLine('Accept'),
                        $supportedValues,
                    )
                ),
                $supportedValues[0],
            );
        }

        $acceptValue = $accept->getValue();

        $request = $request->withAttribute('accept', $acceptValue);

        if (\in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true)) {
            if (null === $contentType = $this->contentTypeNegotiator->negotiate($request)) {
                return $this->responseManager->createFromHttpException(
                    HttpException::createUnsupportedMediaType(
                        $this->aggregateData(
                            'content-type',
                            $request->getHeaderLine('Content-Type'),
                            $this->contentTypeNegotiator->getSupportedMediaTypes()
                        )
                    ),
                    $acceptValue,
                );
            }

            $request = $request->withAttribute('contentType', $contentType->getValue());
        }

        return $handler->handle($request);
    }

    /**
     * @param array<string> $supportedValues
     *
     * @return array<string, array<string>|string>
     */
    private function aggregateData(string $header, string $value, array $supportedValues): array
    {
        return [
            'detail' => sprintf(
                '%s %s, supportedValues: "%s"',
                '' !== $value ? 'Not supported' : 'Missing',
                $header,
                implode('", ', $supportedValues)
            ),
            'value' => $value,
            'supportedValues' => $supportedValues,
        ];
    }
}

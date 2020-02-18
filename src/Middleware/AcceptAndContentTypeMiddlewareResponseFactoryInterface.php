<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Middleware;

use Psr\Http\Message\ResponseInterface;

interface AcceptAndContentTypeMiddlewareResponseFactoryInterface
{
    /**
     * @param string $accept
     * @param array|string[] $acceptableMimeTypes
     * @param string $mimeType
     * @return ResponseInterface
     */
    public function createForNotAcceptable(
        string $accept,
        array $acceptableMimeTypes,
        string $mimeType
    ): ResponseInterface;

    /**
     * @param string $mediaType
     * @param array<int, string> $supportedMediaTypes
     * @param string $mimeType
     * @return ResponseInterface
     */
    public function createForUnsupportedMediaType(
        string $mediaType,
        array $supportedMediaTypes,
        string $mimeType
    ): ResponseInterface;
}

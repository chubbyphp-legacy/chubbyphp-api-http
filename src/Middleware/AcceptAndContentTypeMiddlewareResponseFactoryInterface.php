<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Middleware;

use Psr\Http\Message\ResponseInterface;

interface AcceptAndContentTypeMiddlewareResponseFactoryInterface
{
    public function createForNotAcceptable(
        string $accept,
        array $acceptableMimeTypes,
        string $mimeType
    ): ResponseInterface;

    public function createForUnsupportedMediaType(
        string $mediaType,
        array $supportedMediaTypes,
        string $mimeType
    ): ResponseInterface;
}

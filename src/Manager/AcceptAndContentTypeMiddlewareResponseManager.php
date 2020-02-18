<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable;
use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddlewareResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class AcceptAndContentTypeMiddlewareResponseManager implements AcceptAndContentTypeMiddlewareResponseFactoryInterface
{

    /**
     * @var ResponseManagerInterface
     */
    private $responseManager;

    public function __construct(ResponseManagerInterface $responseManager)
    {
        $this->responseManager = $responseManager;
    }

    public function createForNotAcceptable(
        string $accept,
        array $acceptableMimeTypes,
        string $mimeType
    ): ResponseInterface {
        return $this->responseManager->createFromApiProblem(
            new NotAcceptable($accept, $acceptableMimeTypes), $mimeType
        );
    }

    public function createForUnsupportedMediaType(
        string $mediaType,
        array $supportedMediaTypes,
        string $mimeType
    ): ResponseInterface {
        return $this->responseManager->createFromApiProblem(
            new UnsupportedMediaType($mediaType, $supportedMediaTypes), $mimeType
        );
    }
}

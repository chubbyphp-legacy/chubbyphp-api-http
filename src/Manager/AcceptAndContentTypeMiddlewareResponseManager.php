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

    /**
     * @param string $accept
     * @param array<int, string> $acceptableMimeTypes
     * @param string $mimeType
     * @return ResponseInterface
     */
    public function createForNotAcceptable(
        string $accept,
        array $acceptableMimeTypes,
        string $mimeType
    ): ResponseInterface {
        return $this->responseManager->createFromApiProblem(
            new NotAcceptable($accept, $acceptableMimeTypes),
            $mimeType
        );
    }

    /**
     * @param string $mediaType
     * @param array|string[] $supportedMediaTypes
     * @param string $mimeType
     * @return ResponseInterface
     */
    public function createForUnsupportedMediaType(
        string $mediaType,
        array $supportedMediaTypes,
        string $mimeType
    ): ResponseInterface {
        return $this->responseManager->createFromApiProblem(
            new UnsupportedMediaType($mediaType, $supportedMediaTypes),
            $mimeType
        );
    }
}

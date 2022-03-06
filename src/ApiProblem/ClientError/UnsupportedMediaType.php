<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class UnsupportedMediaType extends AbstractApiProblem
{
    /**
     * @param array<int, string> $supportedMediaTypes
     */
    public function __construct(
        private string $mediaType,
        private array $supportedMediaTypes,
        ?string $detail = null,
        ?string $instance = null
    ) {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.16',
            415,
            'Unsupported Media Type',
            $detail,
            $instance
        );
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * @return array<int, string>
     */
    public function getSupportedMediaTypes(): array
    {
        return $this->supportedMediaTypes;
    }
}

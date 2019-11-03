<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class UnsupportedMediaType extends AbstractApiProblem
{
    /**
     * @var string
     */
    private $mediaType;

    /**
     * @var string[]
     */
    private $supportedMediaTypes = [];

    /**
     * @param string[] $supportedMediaTypes
     */
    public function __construct(
        string $mediaType,
        array $supportedMediaTypes,
        string $detail = null,
        string $instance = null
    ) {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.16',
            415,
            'Unsupported Media Type',
            $detail,
            $instance
        );

        $this->mediaType = $mediaType;
        $this->supportedMediaTypes = $supportedMediaTypes;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * @return string[]
     */
    public function getSupportedMediaTypes(): array
    {
        return $this->supportedMediaTypes;
    }
}

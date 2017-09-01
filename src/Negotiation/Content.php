<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

final class Content
{
    /**
     * @var string
     */
    private $contentType;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param string $contentType
     * @param array  $attributes
     */
    public function __construct(string $contentType, array $attributes)
    {
        $this->contentType = $contentType;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}

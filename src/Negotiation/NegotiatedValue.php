<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

final class NegotiatedValue
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param string $value
     * @param array  $attributes
     */
    public function __construct(string $value, array $attributes = [])
    {
        $this->value = $value;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}

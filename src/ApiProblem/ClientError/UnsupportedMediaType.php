<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class UnsupportedMediaType extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $supportedMediaTypes = [];

    /**
     * @param string[]    $supportedMediaTypes
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $supportedMediaTypes, string $title, string $detail = null, string $instance = null)
    {
        parent::__construct($title, $detail, $instance);

        $this->supportedMediaTypes = $supportedMediaTypes;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 415;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.16';
    }

    /**
     * @return string[]
     */
    public function getSupportedMediaTypes(): array
    {
        return $this->supportedMediaTypes;
    }
}

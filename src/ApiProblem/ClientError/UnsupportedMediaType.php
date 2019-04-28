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
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $supportedMediaTypes, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.16',
            415,
            'Unsupported Media Type',
            $detail,
            $instance
        );

        $this->supportedMediaTypes = $supportedMediaTypes;
    }

    /**
     * @return string[]
     */
    public function getSupportedMediaTypes(): array
    {
        return $this->supportedMediaTypes;
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class NotAcceptable extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $acceptableMediaTypes = [];

    /**
     * @param string[]    $acceptableMediaTypes
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $acceptableMediaTypes, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.7',
            406,
            'Not Acceptable',
            $detail,
            $instance
        );

        $this->acceptableMediaTypes = $acceptableMediaTypes;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        if ([] === $this->acceptableMediaTypes) {
            return [];
        }

        return ['X-Acceptable' => implode(',', $this->acceptableMediaTypes)];
    }

    /**
     * @return string[]
     */
    public function getAcceptableMediaTypes(): array
    {
        return $this->acceptableMediaTypes;
    }
}

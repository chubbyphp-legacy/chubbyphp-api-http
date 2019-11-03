<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class RequestEntityTooLarge extends AbstractApiProblem
{
    /**
     * @var int
     */
    private $maxContentLength;

    public function __construct(int $maxContentLength, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.14',
            413,
            'Request Entity Too Large',
            $detail,
            $instance
        );

        $this->maxContentLength = $maxContentLength;
    }

    public function getMaxContentLength(): int
    {
        return $this->maxContentLength;
    }
}

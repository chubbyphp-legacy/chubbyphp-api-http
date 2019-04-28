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

    /**
     * @param int         $maxContentLength
     * @param string|null $detail
     * @param string|null $instance
     */
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

    /**
     * @return int
     */
    public function getMaxContentLength(): int
    {
        return $this->maxContentLength;
    }
}

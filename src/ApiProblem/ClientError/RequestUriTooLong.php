<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class RequestUriTooLong extends AbstractApiProblem
{
    /**
     * @var int
     */
    private $maxUriLength;

    /**
     * @param int         $maxUriLength
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(int $maxUriLength, string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.15',
            414,
            'Request Uri Too Long',
            $detail,
            $instance
        );

        $this->maxUriLength = $maxUriLength;
    }

    /**
     * @return int
     */
    public function getMaxUriLength(): int
    {
        return $this->maxUriLength;
    }
}

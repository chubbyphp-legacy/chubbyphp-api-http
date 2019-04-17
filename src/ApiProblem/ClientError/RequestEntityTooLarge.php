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
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(int $maxContentLength, string $title, string $detail = null, string $instance = null)
    {
        parent::__construct($title, $detail, $instance);

        $this->maxContentLength = $maxContentLength;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 413;
    }

    /**
     * @return int
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.14';
    }

    /**
     * @return int
     */
    public function getMaxContentLength(): int
    {
        return $this->maxContentLength;
    }
}

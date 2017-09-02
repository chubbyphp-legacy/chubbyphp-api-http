<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

interface NegotiatorInterface
{
    /**
     * @param string $header
     * @param array  $supported
     *
     * @return NegotiatedValue|null
     */
    public function negotiate(string $header, array $supported);
}

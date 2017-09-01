<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

interface ContentNegotiatorInterface
{
    /**
     * @param string $header
     * @param array  $supportedContentTypes
     *
     * @return Content|null
     */
    public function negotiate(string $header, array $supportedContentTypes);
}

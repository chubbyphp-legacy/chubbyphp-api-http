<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.17
 */
final class ContentTypeNegotiator implements NegotiatorInterface
{
    /**
     * @var array
     */
    private $supportedMimeTypes;

    /**
     * @param array $supportedMimeTypes
     */
    public function __construct(array $supportedMimeTypes)
    {
        $this->supportedMimeTypes = $supportedMimeTypes;
    }

    /**
     * @param Request $request
     *
     * @return NegotiatedValue|null
     */
    public function negotiate(Request $request)
    {
        if ([] === $this->supportedMimeTypes) {
            return null;
        }

        if (!$request->hasHeader('Content-Type')) {
            return null;
        }

        return $this->compareAgainstSupportedTypes($request->getHeaderLine('Content-Type'));
    }

    /**
     * @param string $header
     *
     * @return NegotiatedValue|null
     */
    private function compareAgainstSupportedTypes(string $header)
    {
        if (false !== strpos($header, ',')) {
            return null;
        }

        $headerValueParts = explode(';', $header);
        $mimeType = trim(array_shift($headerValueParts));
        $attributes = [];
        foreach ($headerValueParts as $attribute) {
            list($attributeKey, $attributeValue) = explode('=', $attribute);
            $attributes[trim($attributeKey)] = trim($attributeValue);
        }

        if (in_array($mimeType, $this->supportedMimeTypes, true)) {
            return new NegotiatedValue($mimeType, $attributes);
        }

        return null;
    }
}

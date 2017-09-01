<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

final class ContentNegotiator implements ContentNegotiatorInterface
{
    /**
     * @param string $header
     * @param array  $supportedContentTypes
     *
     * @return Content|null
     */
    public function negotiate(string $header, array $supportedContentTypes)
    {
        $values = [];
        foreach (explode(',', $header) as $headerValue) {
            $headerValueParts = explode(';', $headerValue);
            $contentType = trim(array_shift($headerValueParts));
            $attributes = [];
            foreach ($headerValueParts as $attribute) {
                list($attributeKey, $attributeValue) = explode('=', $attribute);
                $attributes[trim($attributeKey)] = trim($attributeValue);
            }

            if (!isset($attributes['q'])) {
                $attributes['q'] = '1.0';
            }

            $values[$contentType] = $attributes;
        }

        uasort($values, function (array $a, array $b) {
            return $b['q'] <=> $a['q'];
        });

        foreach ($values as $contentType => $attributes) {
            list($type, $subType) = explode('/', $contentType);
            $typePattern = '*' !== $type ? preg_quote($type) : '[^\/]+';
            $subTypePattern = '*' !== $subType ? preg_quote($subType) : '[^\/]+';

            foreach ($supportedContentTypes as $supportedContentType) {
                if (1 === preg_match('/^'.$typePattern.'\/'.$subTypePattern.'$/', $supportedContentType)) {
                    return new Content($supportedContentType, $attributes);
                }
            }
        }

        return null;
    }
}

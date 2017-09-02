<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

/**
 * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.1
 */
final class AcceptNegotiator implements NegotiatorInterface
{
    /**
     * @param string $header
     * @param array  $supported
     *
     * @return NegotiatedValue|null
     */
    public function negotiate(string $header, array $supported)
    {
        $aggregatedValues = $this->aggregatedValues($header);

        return $this->compareAgainstSupportedTypes($aggregatedValues, $supported);
    }

    /**
     * @param string $header
     *
     * @return array
     */
    private function aggregatedValues(string $header): array
    {
        $values = [];
        foreach (explode(',', $header) as $headerValue) {
            $headerValueParts = explode(';', $headerValue);
            $mimeType = trim(array_shift($headerValueParts));
            $attributes = [];
            foreach ($headerValueParts as $attribute) {
                list($attributeKey, $attributeValue) = explode('=', $attribute);
                $attributes[trim($attributeKey)] = trim($attributeValue);
            }

            if (!isset($attributes['q'])) {
                $attributes['q'] = '1.0';
            }

            $values[$mimeType] = $attributes;
        }

        uasort($values, function (array $a, array $b) {
            return $b['q'] <=> $a['q'];
        });

        return $values;
    }

    /**
     * @param array $aggregatedValues
     * @param array $supportedMimeTypes
     *
     * @return NegotiatedValue|null
     */
    private function compareAgainstSupportedTypes(array $aggregatedValues, array $supportedMimeTypes)
    {
        if ([] === $supportedMimeTypes) {
            return null;
        }

        foreach ($aggregatedValues as $mimeType => $attributes) {
            if ('*/*' === $mimeType) {
                return new NegotiatedValue(reset($supportedMimeTypes), $attributes);
            }

            list($type, $subType) = explode('/', $mimeType);

            if ('*' === $type && '*' !== $subType) { // skip invalid value
                continue;
            }

            $subTypePattern = $subType !== '*' ? preg_quote($subType) : '.+';

            foreach ($supportedMimeTypes as $supportedMimeType) {
                if (1 === preg_match('/^'.preg_quote($type).'\/'.$subTypePattern.'$/', $supportedMimeType)) {
                    return new NegotiatedValue($supportedMimeType, $attributes);
                }
            }
        }

        return null;
    }
}

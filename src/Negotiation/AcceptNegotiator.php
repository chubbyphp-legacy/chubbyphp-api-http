<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

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

        return $values;
    }

    /**
     * @param array $aggregatedValues
     * @param array $supported
     *
     * @return NegotiatedValue|null
     */
    private function compareAgainstSupportedTypes(array $aggregatedValues, array $supported)
    {
        foreach ($aggregatedValues as $contentType => $attributes) {
            list($type, $subType) = explode('/', $contentType);
            if ('*' === $type) {
                if ('*' !== $subType) {
                    continue;
                }

                foreach ($supported as $supportedContentType) {
                    return new NegotiatedValue($supportedContentType, $attributes);
                }

                continue;
            }

            $subTypePattern = '*' !== $subType ? preg_quote($subType) : '[^\/]+';

            foreach ($supported as $supportedContentType) {
                if (1 === preg_match('/^'.preg_quote($type).'\/'.$subTypePattern.'$/', $supportedContentType)) {
                    return new NegotiatedValue($supportedContentType, $attributes);
                }
            }
        }

        return null;
    }
}

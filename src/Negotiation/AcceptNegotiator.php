<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Negotiation;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.1
 */
final class AcceptNegotiator implements NegotiatorInterface
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

        if (!$request->hasHeader('Accept')) {
            return null;
        }

        $aggregatedValues = $this->aggregatedValues($request->getHeaderLine('Accept'));

        return $this->compareAgainstSupportedTypes($aggregatedValues);
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
     *
     * @return NegotiatedValue|null
     */
    private function compareAgainstSupportedTypes(array $aggregatedValues)
    {
        foreach ($aggregatedValues as $mimeType => $attributes) {
            if ('*/*' === $mimeType) {
                return new NegotiatedValue(reset($this->supportedMimeTypes), $attributes);
            }

            list($type, $subType) = explode('/', $mimeType);

            if ('*' === $type && '*' !== $subType) { // skip invalid value
                continue;
            }

            $subTypePattern = $subType !== '*' ? preg_quote($subType) : '.+';

            foreach ($this->supportedMimeTypes as $supportedMimeType) {
                if (1 === preg_match('/^'.preg_quote($type).'\/'.$subTypePattern.'$/', $supportedMimeType)) {
                    return new NegotiatedValue($supportedMimeType, $attributes);
                }
            }
        }

        return null;
    }
}

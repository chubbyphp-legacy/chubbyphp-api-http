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
    private $supportedMediaTypes;

    /**
     * @param array $supportedMediaTypes
     */
    public function __construct(array $supportedMediaTypes)
    {
        $this->supportedMediaTypes = $supportedMediaTypes;
    }

    /**
     * @param Request $request
     *
     * @return NegotiatedValue|null
     */
    public function negotiate(Request $request)
    {
        if ([] === $this->supportedMediaTypes) {
            return null;
        }

        if (!$request->hasHeader('Accept')) {
            return null;
        }

        $aggregatedValues = $this->aggregatedValues($request->getHeaderLine('Accept'));

        return $this->compareAgainstSupportedMediaTypes($aggregatedValues);
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
            $mediaType = trim(array_shift($headerValueParts));
            $attributes = [];
            foreach ($headerValueParts as $attribute) {
                list($attributeKey, $attributeValue) = explode('=', $attribute);
                $attributes[trim($attributeKey)] = trim($attributeValue);
            }

            if (!isset($attributes['q'])) {
                $attributes['q'] = '1.0';
            }

            $values[$mediaType] = $attributes;
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
    private function compareAgainstSupportedMediaTypes(array $aggregatedValues)
    {
        foreach ($aggregatedValues as $mediaType => $attributes) {
            if ('*/*' === $mediaType) {
                return new NegotiatedValue(reset($this->supportedMediaTypes), $attributes);
            }

            list($type, $subType) = explode('/', $mediaType);

            if ('*' === $type && '*' !== $subType) { // skip invalid value
                continue;
            }

            $subTypePattern = $subType !== '*' ? preg_quote($subType) : '.+';

            foreach ($this->supportedMediaTypes as $supportedMediaType) {
                if (1 === preg_match('/^'.preg_quote($type).'\/'.$subTypePattern.'$/', $supportedMediaType)) {
                    return new NegotiatedValue($supportedMediaType, $attributes);
                }
            }
        }

        return null;
    }
}

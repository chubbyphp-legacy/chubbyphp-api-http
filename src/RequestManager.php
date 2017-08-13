<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp;

use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Deserialization\Transformer\TransformerException;
use Chubbyphp\Deserialization\TransformerInterface;
use Negotiation\Accept as ContentAccept;
use Negotiation\Negotiator as ContentNegotiator;
use Psr\Http\Message\ServerRequestInterface as Request;

final class RequestManager implements RequestManagerInterface
{
    /**
     * @var ContentNegotiator
     */
    private $contentNegotiator;

    /**
     * @var DeserializerInterface
     */
    private $deserializer;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * @param ContentNegotiator     $contentNegotiator
     * @param DeserializerInterface $deserializer
     * @param TransformerInterface  $transformer
     */
    public function __construct(
        ContentNegotiator $contentNegotiator,
        DeserializerInterface $deserializer,
        TransformerInterface $transformer
    ) {
        $this->contentNegotiator = $contentNegotiator;
        $this->deserializer = $deserializer;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return string|null
     */
    public function getAccept(Request $request)
    {
        return $this->negotiate($request, 'Accept');
    }

    /**
     * @param Request $request
     *
     * @return string|null
     */
    public function getContentType(Request $request)
    {
        return $this->negotiate($request, 'Content-Type');
    }

    /**
     * @param Request $request
     * @param string  $headerName
     *
     * @return null|string
     */
    private function negotiate(Request $request, string $headerName)
    {
        if (!$request->hasHeader($headerName)) {
            return null;
        }

        /** @var ContentAccept $best */
        $best = $this->contentNegotiator->getBest(
            $request->getHeaderLine($headerName),
            $this->transformer->getContentTypes()
        );

        if (null === $best) {
            return null;
        }

        return $best->getNormalizedValue();
    }

    /**
     * @param Request       $request
     * @param object|string $object
     *
     * @return object|null
     */
    public function getDataFromRequestBody(Request $request, $object)
    {
        if (null === $contentType = $this->getContentType($request)) {
            return null;
        }

        try {
            $data = $this->transformer->transform((string) $request->getBody(), $contentType);
        } catch (TransformerException $e) {
            return null;
        }

        $method = $this->getSerializerMethod($object);

        return $this->deserializer->$method($data, $object);
    }

    /**
     * @param Request       $request
     * @param object|string $object
     *
     * @return object|null
     */
    public function getDataFromRequestQuery(Request $request, $object)
    {
        $method = $this->getSerializerMethod($object);

        return $this->deserializer->$method($request->getQueryParams(), $object);
    }

    /**
     * @param object|string $object
     *
     * @return string
     */
    private function getSerializerMethod($object): string
    {
        return is_string($object) ? 'deserializeByClass' : 'deserializeByObject';
    }
}

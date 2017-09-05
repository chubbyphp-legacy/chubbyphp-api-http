<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Deserialization\Transformer\TransformerException;
use Chubbyphp\Deserialization\TransformerInterface;
use Chubbyphp\Negotiation\AcceptLanguageNegotiatorInterface;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

final class RequestManager implements RequestManagerInterface
{
    /**
     * @var AcceptNegotiatorInterface
     */
    private $acceptNegotiator;

    /**
     * @var AcceptLanguageNegotiatorInterface
     */
    private $acceptLanguageNegotiator;

    /**
     * @var ContentTypeNegotiatorInterface
     */
    private $contentTypeNegotiator;

    /**
     * @var DeserializerInterface
     */
    private $deserializer;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * @param AcceptNegotiatorInterface         $acceptNegotiator
     * @param AcceptLanguageNegotiatorInterface $acceptLanguageNegotiator
     * @param ContentTypeNegotiatorInterface    $contentTypeNegotiator
     * @param DeserializerInterface             $deserializer
     * @param TransformerInterface              $transformer
     */
    public function __construct(
        AcceptNegotiatorInterface $acceptNegotiator,
        AcceptLanguageNegotiatorInterface $acceptLanguageNegotiator,
        ContentTypeNegotiatorInterface $contentTypeNegotiator,
        DeserializerInterface $deserializer,
        TransformerInterface $transformer
    ) {
        $this->acceptNegotiator = $acceptNegotiator;
        $this->acceptLanguageNegotiator = $acceptLanguageNegotiator;
        $this->contentTypeNegotiator = $contentTypeNegotiator;
        $this->deserializer = $deserializer;
        $this->transformer = $transformer;
    }

    /**
     * @param Request     $request
     * @param string|null $default
     *
     * @return string|null
     */
    public function getAccept(Request $request, string $default = null)
    {
        if (null === $value = $this->acceptNegotiator->negotiate($request)) {
            return $default;
        }

        return $value->getValue();
    }

    /**
     * @param Request     $request
     * @param string|null $default
     *
     * @return string|null
     */
    public function getAcceptLanguage(Request $request, string $default = null)
    {
        if (null === $value = $this->acceptLanguageNegotiator->negotiate($request)) {
            return $default;
        }

        return $value->getValue();
    }

    /**
     * @param Request     $request
     * @param string|null $default
     *
     * @return string|null
     */
    public function getContentType(Request $request, string $default = null)
    {
        if (null === $value = $this->contentTypeNegotiator->negotiate($request)) {
            return $default;
        }

        return $value->getValue();
    }

    /**
     * @param Request       $request
     * @param object|string $object
     * @param string        $contentType
     *
     * @return object|null
     */
    public function getDataFromRequestBody(Request $request, $object, string $contentType)
    {
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
     * @return string[]
     */
    public function getSupportedAccepts(): array
    {
        return $this->acceptNegotiator->getSupportedMediaTypes();
    }

    /**
     * @return string[]
     */
    public function getSupportedContentTypes(): array
    {
        return $this->contentTypeNegotiator->getSupportedMediaTypes();
    }

    /**
     * @return string[]
     */
    public function getSupportedLocales(): array
    {
        return $this->acceptLanguageNegotiator->getSupportedLocales();
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

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
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
     * @param AcceptNegotiatorInterface         $acceptNegotiator
     * @param AcceptLanguageNegotiatorInterface $acceptLanguageNegotiator
     * @param ContentTypeNegotiatorInterface    $contentTypeNegotiator
     * @param DeserializerInterface             $deserializer
     */
    public function __construct(
        AcceptNegotiatorInterface $acceptNegotiator,
        AcceptLanguageNegotiatorInterface $acceptLanguageNegotiator,
        ContentTypeNegotiatorInterface $contentTypeNegotiator,
        DeserializerInterface $deserializer
    ) {
        $this->acceptNegotiator = $acceptNegotiator;
        $this->acceptLanguageNegotiator = $acceptLanguageNegotiator;
        $this->contentTypeNegotiator = $contentTypeNegotiator;
        $this->deserializer = $deserializer;
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
     * @param Request                      $request
     * @param object|string                $object
     * @param string                       $contentType
     * @param DenormalizerContextInterface $context
     *
     * @return object
     */
    public function getDataFromRequestBody(
        Request $request,
        $object,
        string $contentType,
        DenormalizerContextInterface $context = null
    ) {
        return $this->deserializer->deserialize($object, (string) $request->getBody(), $contentType, $context);
    }

    /**
     * @param Request                      $request
     * @param object|string                $object
     * @param DenormalizerContextInterface $context
     *
     * @return object
     */
    public function getDataFromRequestQuery(Request $request, $object, DenormalizerContextInterface $context = null)
    {
        return $this->deserializer->denormalize($object, $request->getQueryParams(), $context);
    }
}

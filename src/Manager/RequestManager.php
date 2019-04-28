<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequestManager implements RequestManagerInterface
{
    /**
     * @var DeserializerInterface
     */
    private $deserializer;

    /**
     * @param DeserializerInterface $deserializer
     */
    public function __construct(DeserializerInterface $deserializer)
    {
        $this->deserializer = $deserializer;
    }

    /**
     * @param ServerRequestInterface            $request
     * @param object|string                     $object
     * @param DenormalizerContextInterface|null $context
     *
     * @return object
     */
    public function getDataFromRequestQuery(
        ServerRequestInterface $request,
        $object,
        DenormalizerContextInterface $context = null
    ) {
        return $this->deserializer->denormalize($object, $request->getQueryParams(), $context);
    }

    /**
     * @param ServerRequestInterface            $request
     * @param object|string                     $object
     * @param string                            $contentType
     * @param DenormalizerContextInterface|null $context
     *
     * @return object
     */
    public function getDataFromRequestBody(
        ServerRequestInterface $request,
        $object,
        string $contentType,
        DenormalizerContextInterface $context = null
    ) {
        return $this->deserializer->deserialize($object, (string) $request->getBody(), $contentType, $context);
    }
}

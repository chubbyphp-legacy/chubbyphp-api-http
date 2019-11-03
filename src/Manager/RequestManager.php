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

    public function __construct(DeserializerInterface $deserializer)
    {
        $this->deserializer = $deserializer;
    }

    /**
     * @param object|string $object
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
     * @param object|string $object
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

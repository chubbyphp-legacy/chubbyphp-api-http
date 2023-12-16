<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequestManager implements RequestManagerInterface
{
    public function __construct(private DeserializerInterface $deserializer) {}

    public function getDataFromRequestQuery(
        ServerRequestInterface $request,
        object|string $object,
        ?DenormalizerContextInterface $context = null
    ): object {
        return $this->deserializer->denormalize($object, $request->getQueryParams(), $context);
    }

    public function getDataFromRequestBody(
        ServerRequestInterface $request,
        object|string $object,
        string $contentType,
        ?DenormalizerContextInterface $context = null
    ): object {
        return $this->deserializer->deserialize($object, (string) $request->getBody(), $contentType, $context);
    }
}

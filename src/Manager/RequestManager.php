<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

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

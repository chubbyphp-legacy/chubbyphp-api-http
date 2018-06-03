<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

interface RequestManagerInterface
{
    /**
     * @param Request                           $request
     * @param object|string                     $object
     * @param DenormalizerContextInterface|null $context
     *
     * @return object
     */
    public function getDataFromRequestQuery(Request $request, $object, DenormalizerContextInterface $context = null);

    /**
     * @param Request       $request
     * @param object|string $object
     * @param string        $contentType
     *
     * @return object|null
     */
    public function getDataFromRequestBody(
        Request $request,
        $object,
        string $contentType,
        DenormalizerContextInterface $context = null
    );
}

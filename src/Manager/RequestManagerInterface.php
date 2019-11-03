<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestManagerInterface
{
    /**
     * @param object|string $object
     *
     * @return object
     */
    public function getDataFromRequestQuery(
        ServerRequestInterface $request,
        $object,
        DenormalizerContextInterface $context = null
    );

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
    );
}

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestManagerInterface
{
    public function getDataFromRequestQuery(
        ServerRequestInterface $request,
        object|string $object,
        ?DenormalizerContextInterface $context = null
    ): object;

    public function getDataFromRequestBody(
        ServerRequestInterface $request,
        object|string $object,
        string $contentType,
        ?DenormalizerContextInterface $context = null
    ): object;
}

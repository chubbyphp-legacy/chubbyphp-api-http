<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestManagerInterface
{
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
    );

    /**
     * @param ServerRequestInterface $request
     * @param object|string          $object
     * @param string                 $contentType
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

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Container;

use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\Serialization\SerializerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

final class ResponseManagerFactory
{
    public function __invoke(ContainerInterface $container): ResponseManagerInterface
    {
        return new ResponseManager(
            $container->get(ResponseFactoryInterface::class),
            $container->get(SerializerInterface::class)
        );
    }
}

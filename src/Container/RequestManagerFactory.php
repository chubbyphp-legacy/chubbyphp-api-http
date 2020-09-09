<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Container;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\RequestManagerInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Psr\Container\ContainerInterface;

/**
 * @deprecated \Chubbyphp\ApiHttp\ServiceFactory\RequestManagerFactory
 */
final class RequestManagerFactory
{
    public function __invoke(ContainerInterface $container): RequestManagerInterface
    {
        return new RequestManager(
            $container->get(DeserializerInterface::class)
        );
    }
}

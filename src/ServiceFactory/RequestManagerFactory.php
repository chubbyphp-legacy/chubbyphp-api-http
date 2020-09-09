<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\RequestManagerInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Deserialization\ServiceFactory\DeserializerFactory;
use Chubbyphp\Laminas\Config\Factory\AbstractFactory;
use Psr\Container\ContainerInterface;

final class RequestManagerFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container): RequestManagerInterface
    {
        /** @var DeserializerInterface $deserializer */
        $deserializer = $this->resolveDependency($container, DeserializerInterface::class, DeserializerFactory::class);

        return new RequestManager($deserializer);
    }
}

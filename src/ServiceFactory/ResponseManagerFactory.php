<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\Laminas\Config\Factory\AbstractFactory;
use Chubbyphp\Serialization\SerializerInterface;
use Chubbyphp\Serialization\ServiceFactory\SerializerFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

final class ResponseManagerFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container): ResponseManagerInterface
    {
        /** @var SerializerInterface $serializer */
        $serializer = $this->resolveDependency($container, SerializerInterface::class, SerializerFactory::class);

        return new ResponseManager(
            $container->get(ResponseFactoryInterface::class),
            $serializer
        );
    }
}

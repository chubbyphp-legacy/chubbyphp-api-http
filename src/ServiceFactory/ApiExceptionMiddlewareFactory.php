<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\ApiExceptionMiddleware;
use Chubbyphp\Laminas\Config\Factory\AbstractFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class ApiExceptionMiddlewareFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container): ApiExceptionMiddleware
    {
        /** @var ResponseManagerInterface $responseManager */
        $responseManager = $this->resolveDependency(
            $container,
            ResponseManagerInterface::class,
            ResponseManagerFactory::class
        );

        return new ApiExceptionMiddleware(
            $responseManager,
            $container->get('config')['debug'],
            $container->has(LoggerInterface::class) ? $container->get(LoggerInterface::class) : new NullLogger()
        );
    }
}

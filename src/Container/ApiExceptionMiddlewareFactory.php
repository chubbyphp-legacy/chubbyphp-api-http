<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Container;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\ApiExceptionMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @deprecated \Chubbyphp\ApiHttp\ServiceFactory\ApiExceptionMiddlewareFactory
 */
final class ApiExceptionMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): ApiExceptionMiddleware
    {
        return new ApiExceptionMiddleware(
            $container->get(ResponseManagerInterface::class),
            $container->get('config')['debug'],
            $container->get(LoggerInterface::class)
        );
    }
}

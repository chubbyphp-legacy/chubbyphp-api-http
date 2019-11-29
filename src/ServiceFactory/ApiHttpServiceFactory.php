<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Psr\Container\ContainerInterface;

final class ApiHttpServiceFactory
{
    public function __invoke(): array
    {
        return [
            'api-http.request.manager' => static function (ContainerInterface $container) {
                return new RequestManager($container->get('deserializer'));
            },
            'api-http.response.manager' => static function (ContainerInterface $container) {
                return new ResponseManager(
                    $container->get('deserializer'),
                    $container->get('api-http.response.factory'),
                    $container->get('serializer')
                );
            },
            'api-http.response.factory' => static function (): void {
                throw new \RuntimeException('Missing response factory, define service "api-http.response.factory"');
            },
        ];
    }
}

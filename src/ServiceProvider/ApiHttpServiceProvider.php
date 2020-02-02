<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ServiceProvider;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

final class ApiHttpServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container['api-http.request.manager'] = static function () use ($container) {
            return new RequestManager($container['deserializer']);
        };

        $container['api-http.response.manager'] = static function () use ($container) {
            return new ResponseManager(
                $container['api-http.response.factory'],
                $container['serializer']
            );
        };

        $container['api-http.response.factory'] = static function (): void {
            throw new \RuntimeException('Missing response factory, define service "api-http.response.factory"');
        };
    }
}

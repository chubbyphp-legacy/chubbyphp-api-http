<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Provider;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

final class ApiHttpProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['api-http.request.manager'] = function () use ($container) {
            return new RequestManager($container['deserializer']);
        };

        $container['api-http.response.manager'] = function () use ($container) {
            return new ResponseManager(
                $container['deserializer'],
                $container['api-http.response.factory'],
                $container['serializer']
            );
        };

        $container['api-http.response.factory'] = function () {
            throw new \RuntimeException('Missing response factory, define service "api-http.response.factory"');
        };
    }
}

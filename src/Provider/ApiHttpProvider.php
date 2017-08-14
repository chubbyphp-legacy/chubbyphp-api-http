<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Provider;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Negotiation\Negotiator as ContentNegotiator;
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
            return new RequestManager(
                $container['api-http.request.contentNegotiator'],
                $container['deserializer'],
                $container['deserializer.transformer']
            );
        };

        $container['api-http.request.contentNegotiator'] = function () {
            return new ContentNegotiator();
        };

        $container['api-http.response.manager'] = function () use ($container) {
            return new ResponseManager(
                $container['api-http.request.manager'],
                $container['api-http.response.factory'],
                $container['serializer'],
                $container['serializer.transformer']
            );
        };

        $container['api-http.response.factory'] = function () {
            throw new \RuntimeException('Missing response factory, define service "api-http.response.factory"');
        };
    }
}

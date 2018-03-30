<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Provider;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Negotiation\AcceptLanguageNegotiator;
use Chubbyphp\Negotiation\AcceptNegotiator;
use Chubbyphp\Negotiation\ContentTypeNegotiator;
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
                $container['api-http.request.acceptNegotiator'],
                $container['api-http.request.acceptLanguageNegotiator'],
                $container['api-http.request.contentTypeNegotiator'],
                $container['deserializer']
            );
        };

        $container['api-http.request.acceptNegotiator'] = function () use ($container) {
            return new AcceptNegotiator($container['api-http.request.accepted']);
        };

        $container['api-http.request.acceptLanguageNegotiator'] = function () use ($container) {
            return new AcceptLanguageNegotiator($container['api-http.request.acceptedLanguages']);
        };

        $container['api-http.request.contentTypeNegotiator'] = function () use ($container) {
            return new ContentTypeNegotiator($container['api-http.request.contentTypes']);
        };

        $container['api-http.request.accepted'] = function () {
            return [];
        };

        $container['api-http.request.acceptedLanguages'] = function () {
            return [];
        };

        $container['api-http.request.contentTypes'] = function () {
            return [];
        };

        $container['api-http.response.manager'] = function () use ($container) {
            return new ResponseManager(
                $container['api-http.response.factory'],
                $container['deserializer'],
                $container['serializer']
            );
        };

        $container['api-http.response.factory'] = function () {
            throw new \RuntimeException('Missing response factory, define service "api-http.response.factory"');
        };
    }
}

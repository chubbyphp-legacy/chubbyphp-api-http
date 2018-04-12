<?php

namespace Chubbyphp\Tests\ApiHttp\Provider;

use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\ApiHttp\Provider\ApiHttpProvider;
use Chubbyphp\Deserialization\Provider\DeserializationProvider;
use Chubbyphp\Serialization\Provider\SerializationProvider;
use PHPUnit\Framework\TestCase;
use Pimple\Container;

/**
 * @covers \Chubbyphp\ApiHttp\Provider\ApiHttpProvider
 */
final class ApiHttpProviderTest extends TestCase
{
    public function testRegister()
    {
        $container = new Container();
        $container->register(new ApiHttpProvider());
        $container->register(new DeserializationProvider());
        $container->register(new SerializationProvider());

        $container['api-http.response.factory'] = function () {
            return $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        };

        self::assertTrue(isset($container['api-http.response.manager']));
        self::assertTrue(isset($container['api-http.response.factory']));

        self::assertInstanceOf(RequestManager::class, $container['api-http.request.manager']);
        self::assertInstanceOf(ResponseManager::class, $container['api-http.response.manager']);
        self::assertInstanceOf(ResponseFactoryInterface::class, $container['api-http.response.factory']);
    }

    public function testFactoryExpectException()
    {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('Missing response factory, define service "api-http.response.factory"');

        $container = new Container();
        $container->register(new ApiHttpProvider());

        $container['api-http.response.factory'];
    }
}

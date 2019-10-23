<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Provider;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\ApiHttp\Provider\ApiHttpProvider;
use Chubbyphp\Deserialization\Provider\DeserializationProvider;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Serialization\Provider\SerializationProvider;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Provider\ApiHttpProvider
 *
 * @internal
 */
final class ApiHttpProviderTest extends TestCase
{
    use MockByCallsTrait;

    public function testRegister(): void
    {
        $container = new Container();
        $container->register(new ApiHttpProvider());
        $container->register(new DeserializationProvider());
        $container->register(new SerializationProvider());

        $container['api-http.response.factory'] = function () {
            return $this->getMockByCalls(ResponseFactoryInterface::class);
        };

        self::assertTrue(isset($container['api-http.response.manager']));
        self::assertTrue(isset($container['api-http.response.factory']));

        self::assertInstanceOf(RequestManager::class, $container['api-http.request.manager']);
        self::assertInstanceOf(ResponseManager::class, $container['api-http.response.manager']);
        self::assertInstanceOf(ResponseFactoryInterface::class, $container['api-http.response.factory']);
    }

    public function testFactoryExpectException(): void
    {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('Missing response factory, define service "api-http.response.factory"');

        $container = new Container();
        $container->register(new ApiHttpProvider());

        $container['api-http.response.factory'];
    }
}

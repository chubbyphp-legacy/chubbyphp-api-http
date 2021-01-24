<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ServiceProvider;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\ApiHttp\ServiceProvider\ApiHttpServiceProvider;
use Chubbyphp\Deserialization\ServiceProvider\DeserializationServiceProvider;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Serialization\ServiceProvider\SerializationServiceProvider;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * @covers \Chubbyphp\ApiHttp\ServiceProvider\ApiHttpServiceProvider
 *
 * @internal
 */
final class ApiHttpServiceProviderTest extends TestCase
{
    use MockByCallsTrait;

    public function testRegister(): void
    {
        /** @var ResponseFactoryInterface $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class);

        $container = new Container();
        $container->register(new ApiHttpServiceProvider());
        $container->register(new DeserializationServiceProvider());
        $container->register(new SerializationServiceProvider());

        $container['api-http.response.factory'] = static fn () => $responseFactory;

        self::assertTrue(isset($container['api-http.response.manager']));
        self::assertTrue(isset($container['api-http.response.factory']));

        self::assertInstanceOf(RequestManager::class, $container['api-http.request.manager']);
        self::assertInstanceOf(ResponseManager::class, $container['api-http.response.manager']);
        self::assertSame($responseFactory, $container['api-http.response.factory']);
    }

    public function testFactoryExpectException(): void
    {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('Missing response factory, define service "api-http.response.factory"');

        $container = new Container();
        $container->register(new ApiHttpServiceProvider());

        $container['api-http.response.factory'];
    }
}

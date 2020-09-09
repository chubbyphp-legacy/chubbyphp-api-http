<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\RequestManagerInterface;
use Chubbyphp\ApiHttp\ServiceFactory\RequestManagerFactory;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\ApiHttp\ServiceFactory\RequestManagerFactory
 *
 * @internal
 */
final class RequestManagerFactoryTest extends TestCase
{
    use MockByCallsTrait;

    public function testInvoke(): void
    {
        /** @var DeserializerInterface $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('has')->with(DeserializerInterface::class)->willReturn(true),
            Call::create('get')->with(DeserializerInterface::class)->willReturn($deserializer),
        ]);

        $factory = new RequestManagerFactory();

        $service = $factory($container);

        self::assertInstanceOf(RequestManagerInterface::class, $service);
    }

    public function testCallStatic(): void
    {
        /** @var DeserializerInterface $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('has')->with(DeserializerInterface::class.'default')->willReturn(true),
            Call::create('get')->with(DeserializerInterface::class.'default')->willReturn($deserializer),
        ]);

        $factory = [RequestManagerFactory::class, 'default'];

        $service = $factory($container);

        self::assertInstanceOf(RequestManagerInterface::class, $service);
    }
}

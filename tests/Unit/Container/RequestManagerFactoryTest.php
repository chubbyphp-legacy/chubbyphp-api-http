<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Container;

use Chubbyphp\ApiHttp\Container\RequestManagerFactory;
use Chubbyphp\ApiHttp\Manager\RequestManagerInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Container\RequestManagerFactory
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
            Call::create('get')->with(DeserializerInterface::class)->willReturn($deserializer),
        ]);

        $factory = new RequestManagerFactory();

        $requestManager = $factory($container);

        self::assertInstanceOf(RequestManagerInterface::class, $requestManager);
    }
}

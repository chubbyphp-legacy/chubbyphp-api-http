<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\ServiceFactory\ResponseManagerFactory;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Serialization\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * @covers \Chubbyphp\ApiHttp\ServiceFactory\ResponseManagerFactory
 *
 * @internal
 */
final class ResponseManagerFactoryTest extends TestCase
{
    use MockByCallsTrait;

    public function testInvoke(): void
    {
        /** @var ResponseFactoryInterface $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class);

        /** @var SerializerInterface $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('has')->with(SerializerInterface::class)->willReturn(true),
            Call::create('get')->with(SerializerInterface::class)->willReturn($serializer),
            Call::create('get')->with(ResponseFactoryInterface::class)->willReturn($responseFactory),
        ]);

        $factory = new ResponseManagerFactory();

        $service = $factory($container);

        self::assertInstanceOf(ResponseManagerInterface::class, $service);
    }

    public function testCallStatic(): void
    {
        /** @var ResponseFactoryInterface $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class);

        /** @var SerializerInterface $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('has')->with(SerializerInterface::class.'default')->willReturn(true),
            Call::create('get')->with(SerializerInterface::class.'default')->willReturn($serializer),
            Call::create('get')->with(ResponseFactoryInterface::class)->willReturn($responseFactory),
        ]);

        $factory = [ResponseManagerFactory::class, 'default'];

        $service = $factory($container);

        self::assertInstanceOf(ResponseManagerInterface::class, $service);
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Container;

use Chubbyphp\ApiHttp\Container\ResponseManagerFactory;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Serialization\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Container\ResponseManagerFactory
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
            Call::create('get')->with(ResponseFactoryInterface::class)->willReturn($responseFactory),
            Call::create('get')->with(SerializerInterface::class)->willReturn($serializer),
        ]);

        $factory = new ResponseManagerFactory();

        $responseManager = $factory($container);

        self::assertInstanceOf(ResponseManagerInterface::class, $responseManager);
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Container;

use Chubbyphp\ApiHttp\Container\ApiExceptionMiddlewareFactory;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\ApiExceptionMiddleware;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Container\ApiExceptionMiddlewareFactory
 *
 * @internal
 */
final class ApiExceptionMiddlewareFactoryTest extends TestCase
{
    use MockByCallsTrait;

    public function testInvoke(): void
    {
        /** @var ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class);

        /** @var LoggerInterface $logger */
        $logger = $this->getMockByCalls(LoggerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('get')->with(ResponseManagerInterface::class)->willReturn($responseManager),
            Call::create('get')->with('config')->willReturn(['debug' => true]),
            Call::create('get')->with(LoggerInterface::class)->willReturn($logger),
        ]);

        $factory = new ApiExceptionMiddlewareFactory();

        $apiExceptionMiddleware = $factory($container);

        self::assertInstanceOf(ApiExceptionMiddleware::class, $apiExceptionMiddleware);
    }
}

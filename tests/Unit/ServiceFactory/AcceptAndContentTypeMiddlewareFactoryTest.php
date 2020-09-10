<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware;
use Chubbyphp\ApiHttp\ServiceFactory\AcceptAndContentTypeMiddlewareFactory;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\ApiHttp\ServiceFactory\AcceptAndContentTypeMiddlewareFactory
 *
 * @internal
 */
final class AcceptAndContentTypeMiddlewareFactoryTest extends TestCase
{
    use MockByCallsTrait;

    public function testInvoke(): void
    {
        /** @var AcceptNegotiatorInterface $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class);

        /** @var ContentTypeNegotiatorInterface $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class);

        /** @var ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('has')->with(AcceptNegotiatorInterface::class)->willReturn(true),
            Call::create('get')
                ->with(AcceptNegotiatorInterface::class)
                ->willReturn($acceptNegotiator),
            Call::create('has')->with(ContentTypeNegotiatorInterface::class)->willReturn(true),
            Call::create('get')
                ->with(ContentTypeNegotiatorInterface::class)
                ->willReturn($contentTypeNegotiator),
            Call::create('has')->with(ResponseManagerInterface::class)->willReturn(true),
            Call::create('get')->with(ResponseManagerInterface::class)->willReturn($responseManager),
        ]);

        $factory = new AcceptAndContentTypeMiddlewareFactory();

        $service = $factory($container);

        self::assertInstanceOf(AcceptAndContentTypeMiddleware::class, $service);
    }

    public function testCallStatic(): void
    {
        /** @var AcceptNegotiatorInterface $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class);

        /** @var ContentTypeNegotiatorInterface $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class);

        /** @var ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('has')->with(AcceptNegotiatorInterface::class.'default')->willReturn(true),
            Call::create('get')
                ->with(AcceptNegotiatorInterface::class.'default')
                ->willReturn($acceptNegotiator),
            Call::create('has')->with(ContentTypeNegotiatorInterface::class.'default')->willReturn(true),
            Call::create('get')
                ->with(ContentTypeNegotiatorInterface::class.'default')
                ->willReturn($contentTypeNegotiator),
            Call::create('has')->with(ResponseManagerInterface::class.'default')->willReturn(true),
            Call::create('get')->with(ResponseManagerInterface::class.'default')->willReturn($responseManager),
        ]);

        $factory = [AcceptAndContentTypeMiddlewareFactory::class, 'default'];

        $service = $factory($container);

        self::assertInstanceOf(AcceptAndContentTypeMiddleware::class, $service);
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Container;

use Chubbyphp\ApiHttp\Container\AcceptAndContentTypeMiddlewareFactory;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Container\AcceptAndContentTypeMiddlewareFactory
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
            Call::create('get')->with(AcceptNegotiatorInterface::class)->willReturn($acceptNegotiator),
            Call::create('get')->with(ContentTypeNegotiatorInterface::class)->willReturn($contentTypeNegotiator),
            Call::create('get')->with(ResponseManagerInterface::class)->willReturn($responseManager),
        ]);

        $factory = new AcceptAndContentTypeMiddlewareFactory();

        $acceptAndContentTypeMiddleware = $factory($container);

        self::assertInstanceOf(AcceptAndContentTypeMiddleware::class, $acceptAndContentTypeMiddleware);
    }
}

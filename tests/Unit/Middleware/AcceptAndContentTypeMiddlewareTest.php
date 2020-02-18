<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Middleware;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable;
use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddlewareResponseFactoryInterface;
use Chubbyphp\Mock\Argument\ArgumentCallback;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Chubbyphp\Negotiation\NegotiatedValueInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware
 *
 * @internal
 */
final class AcceptAndContentTypeMiddlewareTest extends TestCase
{
    use MockByCallsTrait;

    public function testWithoutAccept(): void
    {
        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getHeaderLine')->with('Accept')->willReturn('application/xml'),
        ]);

        /** @var ResponseInterface|MockObject $response */
        $response = $this->getMockByCalls(ResponseInterface::class, []);

        $requestHandler = new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                TestCase::fail('should not be called');
            }
        };

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn(null),
            Call::create('getSupportedMediaTypes')->with()->willReturn(['application/json']),
        ]);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class, []);

        /** @var AcceptAndContentTypeMiddlewareResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(AcceptAndContentTypeMiddlewareResponseFactoryInterface::class, [
            Call::create('createForNotAcceptable')
                ->with('application/xml', ['application/json'], 'application/json')
                ->willReturn($response),
        ]);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseFactory);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithAccept(): void
    {
        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('withAttribute')->with('accept', 'application/json')->willReturnSelf(),
            Call::create('getMethod')->with()->willReturn('GET'),
        ]);

        /** @var ResponseInterface|MockObject $response */
        $response = $this->getMockByCalls(ResponseInterface::class, []);

        $requestHandler = new class($response) implements RequestHandlerInterface {
            /**
             * @var ResponseInterface
             */
            private $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->response;
            }
        };

        /** @var NegotiatedValueInterface|MockObject $accept */
        $accept = $this->getMockByCalls(NegotiatedValueInterface::class, [
            Call::create('getValue')->with()->willReturn('application/json'),
        ]);

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn($accept),
        ]);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class, []);

        /** @var AcceptAndContentTypeMiddlewareResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(AcceptAndContentTypeMiddlewareResponseFactoryInterface::class, []);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseFactory);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithoutContentType(): void
    {
        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('withAttribute')->with('accept', 'application/json')->willReturnSelf(),
            Call::create('getMethod')->with()->willReturn('POST'),
            Call::create('getHeaderLine')->with('Content-Type')->willReturn('application/xml'),
        ]);

        /** @var ResponseInterface|MockObject $response */
        $response = $this->getMockByCalls(ResponseInterface::class, []);

        $requestHandler = new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                TestCase::fail('should not be called');
            }
        };

        /** @var NegotiatedValueInterface|MockObject $accept */
        $accept = $this->getMockByCalls(NegotiatedValueInterface::class, [
            Call::create('getValue')->with()->willReturn('application/json'),
            Call::create('getValue')->with()->willReturn('application/json'),
        ]);

        /** @var AcceptNegotiatorInterface $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn($accept),
        ]);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn(null),
            Call::create('getSupportedMediaTypes')->with()->willReturn(['application/json']),
        ]);

        /** @var AcceptAndContentTypeMiddlewareResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(AcceptAndContentTypeMiddlewareResponseFactoryInterface::class, [
            Call::create('createForUnsupportedMediaType')
                ->with('application/xml', ['application/json'], 'application/json')
                ->willReturn($response),
        ]);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseFactory);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithContentType(): void
    {
        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('withAttribute')->with('accept', 'application/json')->willReturnSelf(),
            Call::create('getMethod')->with()->willReturn('POST'),
            Call::create('withAttribute')->with('contentType', 'application/json')->willReturnSelf(),
        ]);

        /** @var ResponseInterface|MockObject $response */
        $response = $this->getMockByCalls(ResponseInterface::class, []);

        $requestHandler = new class($response) implements RequestHandlerInterface {
            /**
             * @var ResponseInterface
             */
            private $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->response;
            }
        };

        /** @var NegotiatedValueInterface|MockObject $accept */
        $accept = $this->getMockByCalls(NegotiatedValueInterface::class, [
            Call::create('getValue')->with()->willReturn('application/json'),
        ]);

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn($accept),
        ]);

        /** @var NegotiatedValueInterface|MockObject $contentType */
        $contentType = $this->getMockByCalls(NegotiatedValueInterface::class, [
            Call::create('getValue')->with()->willReturn('application/json'),
        ]);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn($contentType),
        ]);

        /** @var AcceptAndContentTypeMiddlewareResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(AcceptAndContentTypeMiddlewareResponseFactoryInterface::class, []);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseFactory);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }
}

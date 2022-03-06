<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Middleware;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable;
use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware;
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
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getHeaderLine')->with('Accept')->willReturn('application/xml'),
        ]);

        /** @var MockObject|ResponseInterface $response */
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

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class, [
            Call::create('createFromApiProblem')
                ->with(
                    new ArgumentCallback(static function (NotAcceptable $apiProblem): void {
                        self::assertSame('application/xml', $apiProblem->getAccept());
                        self::assertSame(['application/json'], $apiProblem->getAcceptables());
                    }),
                    'application/json',
                    null
                )
                ->willReturn($response),
        ]);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseManager);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithAccept(): void
    {
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('withAttribute')->with('accept', 'application/json')->willReturnSelf(),
            Call::create('getMethod')->with()->willReturn('GET'),
        ]);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class, []);

        $requestHandler = new class($response) implements RequestHandlerInterface {
            public function __construct(private ResponseInterface $response)
            {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->response;
            }
        };

        /** @var MockObject|NegotiatedValueInterface $accept */
        $accept = $this->getMockByCalls(NegotiatedValueInterface::class, [
            Call::create('getValue')->with()->willReturn('application/json'),
        ]);

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn($accept),
        ]);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class, []);

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class, []);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseManager);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithoutContentType(): void
    {
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('withAttribute')->with('accept', 'application/json')->willReturnSelf(),
            Call::create('getMethod')->with()->willReturn('POST'),
            Call::create('getHeaderLine')->with('Content-Type')->willReturn('application/xml'),
        ]);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class, []);

        $requestHandler = new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                TestCase::fail('should not be called');
            }
        };

        /** @var MockObject|NegotiatedValueInterface $accept */
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

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class, [
            Call::create('createFromApiProblem')
                ->with(
                    new ArgumentCallback(static function (UnsupportedMediaType $apiProblem): void {
                        self::assertSame('application/xml', $apiProblem->getMediaType());
                        self::assertSame(['application/json'], $apiProblem->getSupportedMediaTypes());
                    }),
                    'application/json',
                    null
                )
                ->willReturn($response),
        ]);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseManager);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithContentType(): void
    {
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('withAttribute')->with('accept', 'application/json')->willReturnSelf(),
            Call::create('getMethod')->with()->willReturn('POST'),
            Call::create('withAttribute')->with('contentType', 'application/json')->willReturnSelf(),
        ]);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class, []);

        $requestHandler = new class($response) implements RequestHandlerInterface {
            public function __construct(private ResponseInterface $response)
            {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->response;
            }
        };

        /** @var MockObject|NegotiatedValueInterface $accept */
        $accept = $this->getMockByCalls(NegotiatedValueInterface::class, [
            Call::create('getValue')->with()->willReturn('application/json'),
        ]);

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockByCalls(AcceptNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn($accept),
        ]);

        /** @var MockObject|NegotiatedValueInterface $contentType */
        $contentType = $this->getMockByCalls(NegotiatedValueInterface::class, [
            Call::create('getValue')->with()->willReturn('application/json'),
        ]);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockByCalls(ContentTypeNegotiatorInterface::class, [
            Call::create('negotiate')->with($request)->willReturn($contentType),
        ]);

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class, []);

        $middleware = new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseManager);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }
}

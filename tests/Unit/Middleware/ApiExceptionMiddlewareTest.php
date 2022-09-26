<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Middleware;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\ApiExceptionMiddleware;
use Chubbyphp\HttpException\HttpExceptionInterface;
use Chubbyphp\Mock\Argument\ArgumentCallback;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Middleware\ApiExceptionMiddleware
 *
 * @internal
 */
final class ApiExceptionMiddlewareTest extends TestCase
{
    use MockByCallsTrait;

    public function testWithoutExceptionWithDebugWithLogger(): void
    {
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class);

        $requestHandler = new class($response) implements RequestHandlerInterface {
            public function __construct(private ResponseInterface $response)
            {
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return $this->response;
            }
        };

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class);

        /** @var LoggerInterface|MockObject $logger */
        $logger = $this->getMockByCalls(LoggerInterface::class);

        $middleware = new ApiExceptionMiddleware($responseManager, true, $logger);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithExceptionWithDebugWithLoggerWithoutAccept(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('runtime exception');
        $this->expectExceptionCode(5000);

        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getAttribute')->with('accept', null)->willReturn(null),
        ]);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class);

        $requestHandler = new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                throw new \RuntimeException('runtime exception', 5000, new \LogicException('logic exception', 10000));
            }
        };

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class);

        /** @var LoggerInterface|MockObject $logger */
        $logger = $this->getMockByCalls(LoggerInterface::class, [
            Call::create('error')
                ->with(
                    'Exception',
                    new ArgumentCallback(static function (array $context): void {
                        $backtrace = $context['backtrace'];

                        self::assertCount(2, $backtrace);

                        $exception = array_shift($backtrace);

                        self::assertSame('RuntimeException', $exception['class']);
                        self::assertSame('runtime exception', $exception['message']);
                        self::assertSame(5000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);

                        $exception = array_shift($backtrace);

                        self::assertSame('LogicException', $exception['class']);
                        self::assertSame('logic exception', $exception['message']);
                        self::assertSame(10000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);
                    })
                ),
        ]);

        $middleware = new ApiExceptionMiddleware($responseManager, true, $logger);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithExceptionWithDebugWithLogger(): void
    {
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getAttribute')->with('accept', null)->willReturn('application/xml'),
        ]);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class);

        $requestHandler = new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                throw new \RuntimeException('runtime exception', 5000, new \LogicException('logic exception', 10000));
            }
        };

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class, [
            Call::create('createFromHttpException')
                ->with(
                    new ArgumentCallback(static function (HttpExceptionInterface $httpException): void {
                        self::assertSame('Internal Server Error', $httpException->getTitle());

                        $data = $httpException->jsonSerialize();

                        self::assertArrayHasKey('backtrace', $data);

                        $backtrace = $data['backtrace'];

                        self::assertCount(2, $backtrace);

                        $exception = array_shift($backtrace);

                        self::assertSame('RuntimeException', $exception['class']);
                        self::assertSame('runtime exception', $exception['message']);
                        self::assertSame(5000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);

                        $exception = array_shift($backtrace);

                        self::assertSame('LogicException', $exception['class']);
                        self::assertSame('logic exception', $exception['message']);
                        self::assertSame(10000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);
                    }),
                    'application/xml',
                )
                ->willReturn($response),
        ]);

        /** @var LoggerInterface|MockObject $logger */
        $logger = $this->getMockByCalls(LoggerInterface::class, [
            Call::create('error')
                ->with(
                    'Exception',
                    new ArgumentCallback(static function (array $context): void {
                        $backtrace = $context['backtrace'];

                        self::assertCount(2, $backtrace);

                        $exception = array_shift($backtrace);

                        self::assertSame('RuntimeException', $exception['class']);
                        self::assertSame('runtime exception', $exception['message']);
                        self::assertSame(5000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);

                        $exception = array_shift($backtrace);

                        self::assertSame('LogicException', $exception['class']);
                        self::assertSame('logic exception', $exception['message']);
                        self::assertSame(10000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);
                    })
                ),
        ]);

        $middleware = new ApiExceptionMiddleware($responseManager, true, $logger);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithExceptionWithoutDebugWithLogger(): void
    {
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getAttribute')->with('accept', null)->willReturn('application/xml'),
        ]);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class);

        $requestHandler = new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                throw new \RuntimeException('runtime exception', 5000, new \LogicException('logic exception', 10000));
            }
        };

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class, [
            Call::create('createFromHttpException')
                ->with(
                    new ArgumentCallback(static function (HttpExceptionInterface $httpException): void {
                        self::assertSame(500, $httpException->getStatus());

                        $data = $httpException->jsonSerialize();

                        self::assertArrayNotHasKey('detail', $data);
                        self::assertArrayNotHasKey('backtrace', $data);
                    }),
                    'application/xml',
                )
                ->willReturn($response),
        ]);

        /** @var LoggerInterface|MockObject $logger */
        $logger = $this->getMockByCalls(LoggerInterface::class, [
            Call::create('error')
                ->with(
                    'Exception',
                    new ArgumentCallback(static function (array $context): void {
                        $backtrace = $context['backtrace'];

                        self::assertCount(2, $backtrace);

                        $exception = array_shift($backtrace);

                        self::assertSame('RuntimeException', $exception['class']);
                        self::assertSame('runtime exception', $exception['message']);
                        self::assertSame(5000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);

                        $exception = array_shift($backtrace);

                        self::assertSame('LogicException', $exception['class']);
                        self::assertSame('logic exception', $exception['message']);
                        self::assertSame(10000, $exception['code']);
                        self::assertArrayHasKey('file', $exception);
                        self::assertArrayHasKey('line', $exception);
                        self::assertArrayHasKey('trace', $exception);
                    })
                ),
        ]);

        $middleware = new ApiExceptionMiddleware($responseManager, false, $logger);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }

    public function testWithExceptionWithoutDebugWithoutLogger(): void
    {
        /** @var MockObject|ServerRequestInterface $request */
        $request = $this->getMockByCalls(ServerRequestInterface::class, [
            Call::create('getAttribute')->with('accept', null)->willReturn('application/xml'),
        ]);

        /** @var MockObject|ResponseInterface $response */
        $response = $this->getMockByCalls(ResponseInterface::class);

        $requestHandler = new class() implements RequestHandlerInterface {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                throw new \RuntimeException('runtime exception', 5000, new \LogicException('logic exception', 10000));
            }
        };

        /** @var MockObject|ResponseManagerInterface $responseManager */
        $responseManager = $this->getMockByCalls(ResponseManagerInterface::class, [
            Call::create('createFromHttpException')
                ->with(
                    new ArgumentCallback(static function (HttpExceptionInterface $httpException): void {
                        self::assertSame(500, $httpException->getStatus());

                        $data = $httpException->jsonSerialize();

                        self::assertArrayNotHasKey('detail', $data);
                        self::assertArrayNotHasKey('backtrace', $data);
                    }),
                    'application/xml',
                )
                ->willReturn($response),
        ]);

        $middleware = new ApiExceptionMiddleware($responseManager);

        self::assertSame($response, $middleware->process($request, $requestHandler));
    }
}

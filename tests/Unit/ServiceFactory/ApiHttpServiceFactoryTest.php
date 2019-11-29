<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\ApiHttp\ServiceFactory\ApiHttpServiceFactory;
use Chubbyphp\Container\Container;
use Chubbyphp\Container\Exceptions\ContainerException;
use Chubbyphp\Deserialization\ServiceFactory\DeserializationServiceFactory;
use Chubbyphp\Mock\MockByCallsTrait;
use Chubbyphp\Serialization\ServiceFactory\SerializationServiceFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * @covers \Chubbyphp\ApiHttp\ServiceFactory\ApiHttpServiceFactory
 *
 * @internal
 */
final class ApiHttpServiceFactoryTest extends TestCase
{
    use MockByCallsTrait;

    public function testRegister(): void
    {
        /** @var ResponseFactoryInterface $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class);

        $container = new Container();
        $container->factories((new ApiHttpServiceFactory())());
        $container->factories((new DeserializationServiceFactory())());
        $container->factories((new SerializationServiceFactory())());

        $container->factory('api-http.response.factory', static function () use ($responseFactory) {
            return $responseFactory;
        });

        self::assertTrue($container->has('api-http.response.manager'));
        self::assertTrue($container->has('api-http.response.factory'));

        self::assertInstanceOf(RequestManager::class, $container->get('api-http.request.manager'));
        self::assertInstanceOf(ResponseManager::class, $container->get('api-http.response.manager'));
        self::assertSame($responseFactory, $container->get('api-http.response.factory'));
    }

    public function testFactoryExpectException(): void
    {
        $container = new Container();
        $container->factories((new ApiHttpServiceFactory())());

        try {
            $container->get('api-http.response.factory');

            self::fail(sprintf('expected "%s"', ContainerException::class));
        } catch (ContainerException $exception) {
            self::assertSame('Could not create service with id "api-http.response.factory"', $exception->getMessage());
            self::assertSame(
                'Missing response factory, define service "api-http.response.factory"',
                $exception->getPrevious()->getMessage()
            );
        }
    }
}

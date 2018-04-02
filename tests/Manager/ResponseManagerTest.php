<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Chubbyphp\Serialization\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\ResponseManager
 */
final class ResponseManagerTest extends TestCase
{
    public function testCreateWithDefaults()
    {
        $bodyString = '{"key": "value"}';

        $object = new \stdClass();

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockBuilder(StreamInterface::class)->getMockForAbstractClass();
        $body->expects(self::once())->method('write')->with($bodyString);

        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($response);

        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($body);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(200)->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($object, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($responseFactory, $serializer);

        self::assertSame($response, $responseManager->create($object, 'application/json'));
    }

    public function testCreateWithoutDefaults()
    {
        $bodyString = '{"key": "value"}';

        $object = new \stdClass();

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockBuilder(StreamInterface::class)->getMockForAbstractClass();
        $body->expects(self::once())->method('write')->with($bodyString);

        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($response);

        $response->expects(self::once())
            ->method('getBody')
            ->willReturn($body);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(NormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(201)->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($object, 'application/json', $context)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($responseFactory, $serializer);

        self::assertSame($response, $responseManager->create($object, 'application/json', 201, $context));
    }

    public function testCreateEmptyWithDefaults()
    {
        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(204)->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();

        $responseManager = new ResponseManager($responseFactory, $serializer);

        self::assertSame($response, $responseManager->createEmpty('application/json'));
    }

    public function testCreateEmptyWithoutDefaults()
    {
        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(200)->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();

        $responseManager = new ResponseManager($responseFactory, $serializer);

        self::assertSame($response, $responseManager->createEmpty('application/json', 200));
    }

    public function testCreateRedirectWithDefaults()
    {
        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Location', 'https://google.com')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(307)->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();

        $responseManager = new ResponseManager($responseFactory, $serializer);

        self::assertSame($response, $responseManager->createRedirect('https://google.com'));
    }

    public function testCreateRedirectWithoutDefaults()
    {
        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Location', 'https://google.com')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(301)->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();

        $responseManager = new ResponseManager($responseFactory, $serializer);

        self::assertSame($response, $responseManager->createRedirect('https://google.com', 301));
    }
}

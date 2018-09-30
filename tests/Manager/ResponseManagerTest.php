<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface as LegacyResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Chubbyphp\Serialization\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\ResponseManager
 */
final class ResponseManagerTest extends TestCase
{
    public function testCreateWithDefaultsAndWrongResponseFactory()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(
            'Chubbyphp\ApiHttp\Manager\ResponseManager::__construct() expects parameter 1 to be'
                .' Psr\Http\Message\ResponseFactoryInterface|Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface'
                .', stdClass given'
         );

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();

        $responseManager = new ResponseManager($deserializer, new \stdClass(), $serializer);
    }

    public function testCreateWithDefaultsAndLegacyResponseFactory()
    {
        $bodyString = '{"key": "value"}';

        $object = new \stdClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

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
        $responseFactory = $this->getMockBuilder(LegacyResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(200)->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($object, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        $error = error_get_last();

        error_clear_last();

        self::assertInternalType('array', $error);
        self::assertArrayHasKey('type', $error);
        self::assertArrayHasKey('message', $error);
        self::assertSame(E_USER_DEPRECATED, $error['type']);
        self::assertSame(
            'Use "Psr\Http\Message\ResponseFactoryInterface" instead of'
                .' "Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface" as __construct argument',
            $error['message']
        );

        self::assertSame($response, $responseManager->create($object, 'application/json'));
    }

    public function testCreateWithDefaults()
    {
        $bodyString = '{"key": "value"}';

        $object = new \stdClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

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
        $responseFactory->expects(self::once())->method('createResponse')->with(200, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($object, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->create($object, 'application/json'));
    }

    public function testCreateWithoutDefaults()
    {
        $bodyString = '{"key": "value"}';

        $object = new \stdClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

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
        $responseFactory->expects(self::once())->method('createResponse')->with(201, '')->willReturn($response);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(NormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($object, 'application/json', $context)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->create($object, 'application/json', 201, $context));
    }

    public function testCreateEmptyWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(204, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::never())->method('serialize');

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createEmpty('application/json'));
    }

    public function testCreateEmptyWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(200, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::never())->method('serialize');

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createEmpty('application/json', 200));
    }

    public function testCreateRedirectWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Location', 'https://google.com')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(307, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::never())->method('serialize');

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createRedirect('https://google.com'));
    }

    public function testCreateRedirectWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('Location', 'https://google.com')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(301, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::never())->method('serialize');

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createRedirect('https://google.com', 301));
    }

    public function testCreateFromErrorWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

        /** @var ErrorInterface|MockObject $error */
        $error = $this->getMockBuilder(ErrorInterface::class)->getMockForAbstractClass();

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
        $responseFactory->expects(self::once())->method('createResponse')->with(400, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createFromError($error, 'application/json'));
    }

    public function testCreateFromErrorWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

        /** @var ErrorInterface|MockObject $error */
        $error = $this->getMockBuilder(ErrorInterface::class)->getMockForAbstractClass();

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
        $responseFactory->expects(self::once())->method('createResponse')->with(418, '')->willReturn($response);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(NormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', $context)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createFromError($error, 'application/json', 418, $context));
    }

    public function testCreateNotAuthenticatedWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

        $error = new Error(
            Error::SCOPE_HEADER,
            'not_authenticated',
            'missing or invalid authentication token to perform the request'
        );

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
        $responseFactory->expects(self::once())->method('createResponse')->with(401, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthenticated('application/json'));
    }

    public function testCreateNotAuthenticatedWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

        $error = new Error(
            Error::SCOPE_HEADER,
            'not_authenticated',
            'missing or invalid authentication token to perform the request'
        );

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
        $responseFactory->expects(self::once())->method('createResponse')->with(401, '')->willReturn($response);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(NormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', $context)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthenticated('application/json', $context));
    }

    public function testCreateNotAuthorizedWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

        $error = new Error(
            Error::SCOPE_HEADER,
            'permission_denied',
            'missing authorization to perform request'
        );

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
        $responseFactory->expects(self::once())->method('createResponse')->with(403, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthorized('application/json'));
    }

    public function testCreateNotAuthorizedWithoutDefaults()
    {
        $error = new Error(
            Error::SCOPE_HEADER,
            'permission_denied',
            'missing authorization to perform request'
        );

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

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
        $responseFactory->expects(self::once())->method('createResponse')->with(403, '')->willReturn($response);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(NormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', $context)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthorized('application/json', $context));
    }

    public function testCreateResourceNotFoundWithDefaults()
    {
        $arguments = ['key' => 'value'];

        $error = new Error(
            Error::SCOPE_RESOURCE,
            'resource_not_found',
            'the requested resource cannot be found',
            null,
            $arguments
        );

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

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
        $responseFactory->expects(self::once())->method('createResponse')->with(404, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createResourceNotFound($arguments, 'application/json'));
    }

    public function testCreateResourceNotFoundWithoutDefaults()
    {
        $arguments = ['key' => 'value'];

        $error = new Error(
            Error::SCOPE_RESOURCE,
            'resource_not_found',
            'the requested resource cannot be found',
            null,
            $arguments
        );

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        $bodyString = '{"key": "value"}';

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
        $responseFactory->expects(self::once())->method('createResponse')->with(404, '')->willReturn($response);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(NormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', $context)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createResourceNotFound($arguments, 'application/json', $context));
    }

    public function testCreateAcceptNotSupported()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::never())->method('getContentTypes');

        /** @var Response|MockObject $response */
        $response = $this->getMockBuilder(Response::class)->getMockForAbstractClass();

        $response->expects(self::once())
            ->method('withHeader')
            ->with('X-Not-Acceptable', 'Accept "application/json" is not supported, supported are "application/xml", "application/xhtml+xml"')
            ->willReturn($response);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)->getMockForAbstractClass();
        $responseFactory->expects(self::once())->method('createResponse')->with(406, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())->method('getContentTypes')->willReturn(['application/xml', 'application/xhtml+xml']);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createAcceptNotSupported('application/json'));
    }

    public function testCreateContentTypeNotSupportedWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::once())->method('getContentTypes')->willReturn(['application/xml', 'application/xhtml+xml']);

        $bodyString = '{"key": "value"}';

        $error = new Error(
            Error::SCOPE_HEADER,
            'contentype_not_supported',
            'the given content type is not supported',
            null,
            [
                'contentType' => 'application/json',
                'supportedContentTypes' => ['application/xml', 'application/xhtml+xml'],
            ]
        );

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
        $responseFactory->expects(self::once())->method('createResponse')->with(415, '')->willReturn($response);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', null)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createContentTypeNotSupported('application/json', 'application/json'));
    }

    public function testCreateContentTypeNotSupportedWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::once())->method('getContentTypes')->willReturn(['application/xml', 'application/xhtml+xml']);

        $bodyString = '{"key": "value"}';

        $error = new Error(
            Error::SCOPE_HEADER,
            'contentype_not_supported',
            'the given content type is not supported',
            null,
            [
                'contentType' => 'application/json',
                'supportedContentTypes' => ['application/xml', 'application/xhtml+xml'],
            ]
        );

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
        $responseFactory->expects(self::once())->method('createResponse')->with(415, '')->willReturn($response);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(NormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockBuilder(SerializerInterface::class)->getMockForAbstractClass();
        $serializer->expects(self::once())
            ->method('serialize')
            ->with($error, 'application/json', $context)
            ->willReturn($bodyString);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createContentTypeNotSupported('application/json', 'application/json', $context));
    }
}

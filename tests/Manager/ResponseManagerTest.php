<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface as LegacyResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Mock\Argument\ArgumentCallback;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
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
    use MockByCallsTrait;

    public function testCreateWithDefaultsAndWrongResponseFactory()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(
            'Chubbyphp\ApiHttp\Manager\ResponseManager::__construct() expects parameter 1 to be'
                .' Psr\Http\Message\ResponseFactoryInterface|Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface'
                .', stdClass given'
         );

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class);

        $responseManager = new ResponseManager($deserializer, new \stdClass(), $serializer);
    }

    public function testCreateWithDefaultsAndLegacyResponseFactory()
    {
        $bodyString = '{"key": "value"}';

        $object = new \stdClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(LegacyResponseFactoryInterface::class, [
            Call::create('createResponse')->with(200)->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')->with($object, 'application/json', null, '')->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        $error = error_get_last();

        error_clear_last();

        self::assertIsArray($error);
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
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(200, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')->with($object, 'application/json', null, '')->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->create($object, 'application/json'));
    }

    public function testCreateWithoutDefaults()
    {
        $bodyString = '{"key": "value"}';

        $object = new \stdClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(201, '')->willReturn($response),
        ]);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(NormalizerContextInterface::class);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')->with($object, 'application/json', $context, '')->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->create($object, 'application/json', 201, $context));
    }

    public function testCreateEmptyWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(204, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createEmpty('application/json'));
    }

    public function testCreateEmptyWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(200, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createEmpty('application/json', 200));
    }

    public function testCreateRedirectWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Location', 'https://google.com')->willReturnSelf(),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(307, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createRedirect('https://google.com'));
    }

    public function testCreateRedirectWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Location', 'https://google.com')->willReturnSelf(),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(301, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createRedirect('https://google.com', 301));
    }

    public function testCreateFromErrorWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var ErrorInterface|MockObject $error */
        $error = $this->getMockByCalls(ErrorInterface::class);

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(400, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')->with($error, 'application/json', null, '')->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createFromError($error, 'application/json'));
    }

    public function testCreateFromErrorWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var ErrorInterface|MockObject $error */
        $error = $this->getMockByCalls(ErrorInterface::class);

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(418, '')->willReturn($response),
        ]);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(NormalizerContextInterface::class);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')->with($error, 'application/json', $context, '')->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createFromError($error, 'application/json', 418, $context));
    }

    public function testCreateNotAuthenticatedWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(401, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_HEADER, $error->getScope());
                        self::assertSame('not_authenticated', $error->getKey());
                        self::assertSame(
                            'missing or invalid authentication token to perform the request',
                            $error->getDetail()
                        );
                        self::assertNull($error->getReference());
                        self::assertSame([], $error->getArguments());
                    }),
                    'application/json',
                    null,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthenticated('application/json'));
    }

    public function testCreateNotAuthenticatedWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(401, '')->willReturn($response),
        ]);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(NormalizerContextInterface::class);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_HEADER, $error->getScope());
                        self::assertSame('not_authenticated', $error->getKey());
                        self::assertSame(
                            'missing or invalid authentication token to perform the request',
                            $error->getDetail()
                        );
                        self::assertNull($error->getReference());
                        self::assertSame([], $error->getArguments());
                    }),
                    'application/json',
                    $context,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthenticated('application/json', $context));
    }

    public function testCreateNotAuthorizedWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(403, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_HEADER, $error->getScope());
                        self::assertSame('permission_denied', $error->getKey());
                        self::assertSame('missing authorization to perform request', $error->getDetail());
                        self::assertNull($error->getReference());
                        self::assertSame([], $error->getArguments());
                    }),
                    'application/json',
                    null,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthorized('application/json'));
    }

    public function testCreateNotAuthorizedWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(403, '')->willReturn($response),
        ]);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(NormalizerContextInterface::class);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_HEADER, $error->getScope());
                        self::assertSame('permission_denied', $error->getKey());
                        self::assertSame('missing authorization to perform request', $error->getDetail());
                        self::assertNull($error->getReference());
                        self::assertSame([], $error->getArguments());
                    }),
                    'application/json',
                    $context,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createNotAuthorized('application/json', $context));
    }

    public function testCreateResourceNotFoundWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(404, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_RESOURCE, $error->getScope());
                        self::assertSame('resource_not_found', $error->getKey());
                        self::assertSame('the requested resource cannot be found', $error->getDetail());
                        self::assertNull($error->getReference());
                        self::assertSame(['key' => 'value'], $error->getArguments());
                    }),
                    'application/json',
                    null,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame(
            $response,
            $responseManager->createResourceNotFound(['key' => 'value'], 'application/json')
        );
    }

    public function testCreateResourceNotFoundWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(404, '')->willReturn($response),
        ]);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(NormalizerContextInterface::class);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_RESOURCE, $error->getScope());
                        self::assertSame('resource_not_found', $error->getKey());
                        self::assertSame('the requested resource cannot be found', $error->getDetail());
                        self::assertNull($error->getReference());
                        self::assertSame(['key' => 'value'], $error->getArguments());
                    }),
                    'application/json',
                    $context,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame(
            $response,
            $responseManager->createResourceNotFound(['key' => 'value'], 'application/json', $context)
        );
    }

    public function testCreateAcceptNotSupported()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')
                ->with(
                    'X-Not-Acceptable',
                    'Accept "application/json" is not supported, supported are "application/xml", "application/xhtml+xml"'
                )
                ->willReturnSelf(),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(406, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('getContentTypes')->with()->willReturn(['application/xml', 'application/xhtml+xml']),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame($response, $responseManager->createAcceptNotSupported('application/json'));
    }

    public function testCreateContentTypeNotSupportedWithDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class, [
            Call::create('getContentTypes')->with()->willReturn(['application/xml', 'application/xhtml+xml']),
        ]);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(415, '')->willReturn($response),
        ]);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_HEADER, $error->getScope());
                        self::assertSame('contentype_not_supported', $error->getKey());
                        self::assertSame('the given content type is not supported', $error->getDetail());
                        self::assertNull($error->getReference());
                        self::assertSame([
                            'contentType' => 'application/json',
                            'supportedContentTypes' => ['application/xml', 'application/xhtml+xml'],
                        ], $error->getArguments());
                    }),
                    'application/json',
                    null,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame(
            $response,
            $responseManager->createContentTypeNotSupported('application/json', 'application/json')
        );
    }

    public function testCreateContentTypeNotSupportedWithoutDefaults()
    {
        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class, [
            Call::create('getContentTypes')->with()->willReturn(['application/xml', 'application/xhtml+xml']),
        ]);

        $bodyString = '{"key": "value"}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('write')->with($bodyString),
        ]);

        /** @var Response|MockObject $response */
        $response = $this->getMockByCalls(Response::class, [
            Call::create('withHeader')->with('Content-Type', 'application/json')->willReturnSelf(),
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var ResponseFactoryInterface|MockObject $responseFactory */
        $responseFactory = $this->getMockByCalls(ResponseFactoryInterface::class, [
            Call::create('createResponse')->with(415, '')->willReturn($response),
        ]);

        /** @var NormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(NormalizerContextInterface::class);

        /** @var SerializerInterface|MockObject $serializer */
        $serializer = $this->getMockByCalls(SerializerInterface::class, [
            Call::create('serialize')
                ->with(
                    new ArgumentCallback(function ($error) {
                        self::assertInstanceOf(ErrorInterface::class, $error);
                        self::assertSame(ErrorInterface::SCOPE_HEADER, $error->getScope());
                        self::assertSame('contentype_not_supported', $error->getKey());
                        self::assertSame('the given content type is not supported', $error->getDetail());
                        self::assertNull($error->getReference());
                        self::assertSame([
                            'contentType' => 'application/json',
                            'supportedContentTypes' => ['application/xml', 'application/xhtml+xml'],
                        ], $error->getArguments());
                    }),
                    'application/json',
                    $context,
                    ''
                )
                ->willReturn($bodyString),
        ]);

        $responseManager = new ResponseManager($deserializer, $responseFactory, $serializer);

        self::assertSame(
            $response,
            $responseManager->createContentTypeNotSupported('application/json', 'application/json', $context)
        );
    }
}

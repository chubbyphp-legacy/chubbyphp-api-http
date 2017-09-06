<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Deserialization\Transformer\TransformerException;
use Chubbyphp\Deserialization\TransformerInterface;
use Chubbyphp\Negotiation\AcceptLanguageNegotiatorInterface;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Chubbyphp\Negotiation\NegotiatedValue;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\RequestManager
 */
final class RequestManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccept()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator(['application/json']),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept' => 'application/json']]);

        self::assertSame('application/json', $requestManager->getAccept($request));
    }

    public function testGetAcceptWithoutHeader()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest();

        self::assertNull($requestManager->getAccept($request));
    }

    public function testGetAcceptWithoutHeaderButWithDefault()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest();

        self::assertSame('application/json', $requestManager->getAccept($request, 'application/json'));
    }

    public function testGetAcceptWithoutBest()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept' => 'application/json']]);

        self::assertNull($requestManager->getAccept($request));
    }

    public function testGetAcceptWithoutBestButWithDefault()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept' => 'application/json']]);

        self::assertSame('application/json', $requestManager->getAccept($request, 'application/json'));
    }

    public function testGetAcceptLanguage()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator(['de', 'en']),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept-Language' => 'en']]);

        self::assertSame('en', $requestManager->getAcceptLanguage($request));
    }

    public function testGetAcceptLanguageWithoutHeader()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator(['de', 'en']),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest();

        self::assertNull($requestManager->getAcceptLanguage($request));
    }

    public function testGetAcceptLanguageWithoutHeaderButWithDefault()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator(['de', 'en']),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );
        $request = $this->getRequest();

        self::assertSame('en', $requestManager->getAcceptLanguage($request, 'en'));
    }

    public function testGetAcceptLanguageWithoutBest()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept-Language' => 'en']]);

        self::assertNull($requestManager->getAcceptLanguage($request));
    }

    public function testGetAcceptLanguageWithoutBestButWithDefault()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept-Language' => 'en']]);

        self::assertSame('en', $requestManager->getAcceptLanguage($request, 'en'));
    }

    public function testGetContentType()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator(['application/json']),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json']]);

        self::assertSame('application/json', $requestManager->getContentType($request));
    }

    public function testGetContentTypeWithoutHeader()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator(['application/json']),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest();

        self::assertNull($requestManager->getContentType($request));
    }

    public function testGetContentTypeWithoutHeaderButWithDefault()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator(['application/json']),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest();

        self::assertSame('application/json', $requestManager->getContentType($request, 'application/json'));
    }

    public function testGetContentTypeWithoutBest()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json']]);

        self::assertNull($requestManager->getContentType($request));
    }

    public function testGetContentTypeWithoutBestButWithDefault()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator(['application/json']),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json']]);

        self::assertSame('application/json', $requestManager->getContentType($request, 'application/json'));
    }

    public function testGetDataFromRequestBody()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator(['application/json']),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json'], 'body' => '{"key":"value"}']);

        self::assertEquals(
            ['key' => 'value'],
            (array) $requestManager->getDataFromRequestBody($request, new \stdClass(), 'application/json')
        );
    }

    public function testGetDataFromRequestBodyWithTransformException()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator(['application/json']),
            $this->getDeserializer(),
            $this->getTransformer(TransformerException::create('content'))
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json'], 'body' => '{"key":"value"}']);

        self::assertNull($requestManager->getDataFromRequestBody($request, new \stdClass(), 'application/json'));
    }

    public function testGetDataFromRequestQuery()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer(TransformerException::create('content'))
        );

        $request = $this->getRequest(['queryParams' => ['key' => 'value']]);

        self::assertEquals(
            ['key' => 'value'],
            (array) $requestManager->getDataFromRequestQuery($request, new \stdClass())
        );
    }

    public function testGetSupportedAccepts()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator(['application/json']),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        self::assertEquals(
            ['application/json'],
            $requestManager->getSupportedAccepts()
        );
    }

    public function testGetSupportedContentTypes()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator([]),
            $this->getContentTypeNegotiator(['application/json']),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        self::assertEquals(
            ['application/json'],
            $requestManager->getSupportedContentTypes()
        );
    }

    public function testGetSupportedLocales()
    {
        $requestManager = new RequestManager(
            $this->getAcceptNegotiator([]),
            $this->getAcceptLanguageNegotiator(['en']),
            $this->getContentTypeNegotiator([]),
            $this->getDeserializer(),
            $this->getTransformer()
        );

        self::assertEquals(
            ['en'],
            $requestManager->getSupportedLocales()
        );
    }

    /**
     * @param array $supportedMediaTypes
     *
     * @return AcceptNegotiatorInterface
     */
    private function getAcceptNegotiator(array $supportedMediaTypes = []): AcceptNegotiatorInterface
    {
        /** @var AcceptNegotiatorInterface|\PHPUnit_Framework_MockObject_MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)
            ->setMethods(['getSupportedMediaTypes', 'negotiate'])
            ->getMockForAbstractClass();

        $acceptNegotiator->expects(self::any())->method('getSupportedMediaTypes')->willReturn($supportedMediaTypes);

        $acceptNegotiator->expects(self::any())->method('negotiate')->willReturnCallback(
            function (Request $request) use ($supportedMediaTypes) {
                if (!$request->hasHeader('Accept')) {
                    return null;
                }

                $headerLine = $request->getHeaderLine('Accept');
                if (in_array($headerLine, $supportedMediaTypes, true)) {
                    return new NegotiatedValue($headerLine);
                }

                return null;
            }
        );

        return $acceptNegotiator;
    }

    /**
     * @param array $supportedLocales
     *
     * @return AcceptLanguageNegotiatorInterface
     */
    private function getAcceptLanguageNegotiator(array $supportedLocales = []): AcceptLanguageNegotiatorInterface
    {
        /** @var AcceptLanguageNegotiatorInterface|\PHPUnit_Framework_MockObject_MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)
            ->setMethods(['getSupportedLocales', 'negotiate'])
            ->getMockForAbstractClass();

        $acceptLanguageNegotiator->expects(self::any())->method('getSupportedLocales')->willReturn($supportedLocales);

        $acceptLanguageNegotiator->expects(self::any())->method('negotiate')->willReturnCallback(
            function (Request $request) use ($supportedLocales) {
                if (!$request->hasHeader('Accept-Language')) {
                    return null;
                }

                $headerLine = $request->getHeaderLine('Accept-Language');

                if (in_array($headerLine, $supportedLocales, true)) {
                    return new NegotiatedValue($headerLine);
                }

                return null;
            }
        );

        return $acceptLanguageNegotiator;
    }

    /**
     * @param array $supportedMediaTypes
     *
     * @return ContentTypeNegotiatorInterface
     */
    private function getContentTypeNegotiator(array $supportedMediaTypes = []): ContentTypeNegotiatorInterface
    {
        /** @var ContentTypeNegotiatorInterface|\PHPUnit_Framework_MockObject_MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)
            ->setMethods(['getSupportedMediaTypes', 'negotiate'])
            ->getMockForAbstractClass();

        $contentTypeNegotiator->expects(self::any())->method('getSupportedMediaTypes')->willReturn($supportedMediaTypes);

        $contentTypeNegotiator->expects(self::any())->method('negotiate')->willReturnCallback(
            function (Request $request) use ($supportedMediaTypes) {
                if (!$request->hasHeader('Content-Type')) {
                    return null;
                }

                $headerLine = $request->getHeaderLine('Content-Type');

                if (in_array($headerLine, $supportedMediaTypes, true)) {
                    return new NegotiatedValue($headerLine);
                }

                return null;
            }
        );

        return $contentTypeNegotiator;
    }

    /**
     * @return DeserializerInterface
     */
    private function getDeserializer(): DeserializerInterface
    {
        /** @var DeserializerInterface|\PHPUnit_Framework_MockObject_MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)
            ->setMethods(['deserializeByClass', 'deserializeByObject'])
            ->getMockForAbstractClass();

        $deserializer->expects(self::any())->method('deserializeByClass')->willReturnCallback(
            function (array $serializedData, string $class, string $path = '') {
                $object = new \stdClass();
                foreach ($serializedData as $property => $value) {
                    $object->$property = $value;
                }

                return $object;
            }
        );

        $deserializer->expects(self::any())->method('deserializeByObject')->willReturnCallback(
            function (array $serializedData, $object, string $path = '') {
                foreach ($serializedData as $property => $value) {
                    $object->$property = $value;
                }

                return $object;
            }
        );

        return $deserializer;
    }

    /**
     * @param TransformerException|null $exception
     *
     * @return TransformerInterface
     */
    private function getTransformer(TransformerException $exception = null): TransformerInterface
    {
        /** @var TransformerInterface|\PHPUnit_Framework_MockObject_MockObject $transform */
        $transform = $this->getMockBuilder(TransformerInterface::class)
            ->setMethods(['getContentTypes', 'transform'])
            ->getMockForAbstractClass();

        $transform->expects(self::any())->method('getContentTypes')->willReturnCallback(
            function () {
                return [];
            }
        );

        $transform->expects(self::any())->method('transform')->willReturnCallback(
            function (string $string, string $contentType) use ($exception) {
                if (null !== $exception) {
                    throw $exception;
                }

                self::assertSame('application/json', $contentType);

                return json_decode($string, true);
            }
        );

        return $transform;
    }

    /**
     * @return Request
     */
    private function getRequest(array $data = []): Request
    {
        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['hasHeader', 'getHeaderLine', 'getQueryParams', 'getBody'])
            ->getMockForAbstractClass();

        $request->expects(self::any())->method('hasHeader')->willReturnCallback(
            function ($name) use ($data) {
                return isset($data['headers'][$name]);
            }
        );

        $request->expects(self::any())->method('getHeaderLine')->willReturnCallback(
            function ($name) use ($data) {
                return $data['headers'][$name] ?? null;
            }
        );

        $request->expects(self::any())->method('getQueryParams')->willReturnCallback(
            function () use ($data) {
                return $data['queryParams'] ?? [];
            }
        );

        $request->expects(self::any())->method('getBody')->willReturnCallback(
            function () use ($data) {
                return $data['body'] ?? '';
            }
        );

        return $request;
    }
}

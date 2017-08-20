<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Deserialization\Transformer\TransformerException;
use Chubbyphp\Deserialization\TransformerInterface;
use Negotiation\Accept as AcceptContent;
use Negotiation\AcceptLanguage;
use Negotiation\LanguageNegotiator;
use Negotiation\Negotiator as ContentNegotiator;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\RequestManager
 */
final class RequestManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccept()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator($this->getContent('application/json')),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );
        $request = $this->getRequest(['headers' => ['Accept' => 'application/json']]);

        self::assertSame('application/json', $requestManager->getAccept($request));
    }

    public function testGetAcceptWithoutHeader()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );
        $request = $this->getRequest();

        self::assertNull($requestManager->getAccept($request));
    }

    public function testGetAcceptWithoutBest()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept' => 'application/json']]);

        self::assertNull($requestManager->getAccept($request));
    }

    public function testGetAcceptLanguage()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator($this->getLanguage('en')),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept-Language' => 'en']]);

        self::assertSame('en', $requestManager->getAcceptLanguage($request));
    }

    public function testGetAcceptLanguageWithoutHeader()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator($this->getLanguage('en')),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest();

        self::assertNull($requestManager->getAcceptLanguage($request));
    }

    public function testGetAcceptLanguageWithoutBest()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Accept-Language' => 'en']]);

        self::assertNull($requestManager->getAcceptLanguage($request));
    }

    public function testGetContentType()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator($this->getContent('application/json')),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json']]);

        self::assertSame('application/json', $requestManager->getContentType($request));
    }

    public function testGetContentTypeWithoutHeader()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest();

        self::assertNull($requestManager->getContentType($request));
    }

    public function testGetContentTypeWithoutBest()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json']]);

        self::assertNull($requestManager->getContentType($request));
    }

    public function testGetDataFromRequestBody()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator($this->getContent('application/json')),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json'], 'body' => '{"key":"value"}']);

        self::assertEquals(
            ['key' => 'value'],
            (array) $requestManager->getDataFromRequestBody($request, new \stdClass())
        );
    }

    public function testGetDataFromRequestBodyWithoutContentType()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator($this->getContent('application/json')),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer(TransformerException::create('content'))
        );

        $request = $this->getRequest(['body' => '{"key":"value"}']);

        self::assertNull($requestManager->getDataFromRequestBody($request, new \stdClass()));
    }

    public function testGetDataFromRequestBodyWithTransformException()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator($this->getContent('application/json')),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer(TransformerException::create('content'))
        );

        $request = $this->getRequest(['headers' => ['Content-Type' => 'application/json'], 'body' => '{"key":"value"}']);

        self::assertNull($requestManager->getDataFromRequestBody($request, new \stdClass()));
    }

    public function testGetDataFromRequestQuery()
    {
        $requestManager = new RequestManager(
            $this->getContentNegotiator(),
            $this->getDeserializer(),
            $this->getLanguageNegotiator(),
            ['de', 'en'],
            $this->getTransformer()
        );

        $request = $this->getRequest(['queryParams' => ['key' => 'value']]);

        self::assertEquals(
            ['key' => 'value'],
            (array) $requestManager->getDataFromRequestQuery($request, new \stdClass())
        );
    }

    /**
     * @param AcceptContent|null $best
     *
     * @return ContentNegotiator
     */
    private function getContentNegotiator(AcceptContent $best = null): ContentNegotiator
    {
        /** @var ContentNegotiator|\PHPUnit_Framework_MockObject_MockObject $contentNegotiator */
        $contentNegotiator = $this->getMockBuilder(ContentNegotiator::class)
            ->setMethods(['getBest'])
            ->getMock();

        $contentNegotiator->expects(self::any())->method('getBest')->willReturnCallback(
            function () use ($best) {
                return $best;
            }
        );

        return $contentNegotiator;
    }

    /**
     * @param AcceptLanguage|null $best
     *
     * @return LanguageNegotiator
     */
    private function getLanguageNegotiator(AcceptLanguage $best = null): LanguageNegotiator
    {
        /** @var LanguageNegotiator|\PHPUnit_Framework_MockObject_MockObject $languageNegotiator */
        $languageNegotiator = $this->getMockBuilder(LanguageNegotiator::class)
            ->setMethods(['getBest'])
            ->getMock();

        $languageNegotiator->expects(self::any())->method('getBest')->willReturnCallback(
            function () use ($best) {
                return $best;
            }
        );

        return $languageNegotiator;
    }

    /**
     * @param string $normalizeValue
     *
     * @return AcceptContent
     */
    private function getContent(string $normalizeValue): AcceptContent
    {
        return new AcceptContent($normalizeValue);
    }

    /**
     * @param string $normalizeValue
     *
     * @return AcceptLanguage
     */
    private function getLanguage(string $normalizeValue): AcceptLanguage
    {
        return new AcceptLanguage($normalizeValue);
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

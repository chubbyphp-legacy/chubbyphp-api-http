<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Negotiation\AcceptLanguageNegotiatorInterface;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Chubbyphp\Negotiation\NegotiatedValueInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\RequestManager
 */
final class RequestManagerTest extends TestCase
{
    public function testAcceptWithoutMatch()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();
        $acceptNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn(null);

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertNull($manager->getAccept($request));
    }

    public function testAcceptWithoutMatchAndChangedDefault()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();
        $acceptNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn(null);

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame('application/json', $manager->getAccept($request, 'application/json'));
    }

    public function testAcceptWithMatch()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var NegotiatedValueInterface|MockObject $negotiatedValue */
        $negotiatedValue = $this->getMockBuilder(NegotiatedValueInterface::class)->getMockForAbstractClass();
        $negotiatedValue->expects(self::once())->method('getValue')->with()->willReturn('application/json');

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();
        $acceptNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn($negotiatedValue);

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame('application/json', $manager->getAccept($request));
    }

    public function testAcceptLanguageWithoutMatch()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();
        $acceptLanguageNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn(null);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertNull($manager->getAcceptLanguage($request));
    }

    public function testAcceptLanguageWithoutMatchAndChangedDefault()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();
        $acceptLanguageNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn(null);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame('de_CH', $manager->getAcceptLanguage($request, 'de_CH'));
    }

    public function testAcceptLanguageWithMatch()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var NegotiatedValueInterface|MockObject $negotiatedValue */
        $negotiatedValue = $this->getMockBuilder(NegotiatedValueInterface::class)->getMockForAbstractClass();
        $negotiatedValue->expects(self::once())->method('getValue')->with()->willReturn('de_CH');

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();
        $acceptLanguageNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn($negotiatedValue);

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame('de_CH', $manager->getAcceptLanguage($request));
    }

    public function testContentTypeWithoutMatch()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();
        $contentTypeNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn(null);

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertNull($manager->getContentType($request));
    }

    public function testContentTypeWithoutMatchAndChangedDefault()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();
        $contentTypeNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn(null);

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame('application/json', $manager->getContentType($request, 'application/json'));
    }

    public function testContentTypeWithMatch()
    {
        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var NegotiatedValueInterface|MockObject $negotiatedValue */
        $negotiatedValue = $this->getMockBuilder(NegotiatedValueInterface::class)->getMockForAbstractClass();
        $negotiatedValue->expects(self::once())->method('getValue')->with()->willReturn('application/json');

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();
        $contentTypeNegotiator->expects(self::once())->method('negotiate')->with($request)->willReturn($negotiatedValue);

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame('application/json', $manager->getContentType($request));
    }

    public function testGetDataFromRequestBody()
    {
        $object = new \stdClass();

        $bodyString = '{"key": "value}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockBuilder(StreamInterface::class)->getMockForAbstractClass();
        $body->expects(self::once())->method('__toString')->willReturn($bodyString);

        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();
        $request->expects(self::once())->method('getBody')->willReturn($body);

        /** @var DenormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(DenormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::once())
            ->method('deserialize')
            ->with($object, $bodyString, 'application/json', $context)
            ->willReturn($object);

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame(
            $object,
            $manager->getDataFromRequestBody($request, $object, 'application/json', $context)
        );
    }

    public function testGetDataFromRequestQuery()
    {
        $object = new \stdClass();

        $queryParams = ['key' => 'value'];

        /** @var Request|MockObject $request */
        $request = $this->getMockBuilder(Request::class)->getMockForAbstractClass();
        $request->expects(self::once())->method('getQueryParams')->willReturn($queryParams);

        /** @var DenormalizerContextInterface|MockObject $context */
        $context = $this->getMockBuilder(DenormalizerContextInterface::class)->getMockForAbstractClass();

        /** @var AcceptNegotiatorInterface|MockObject $acceptNegotiator */
        $acceptNegotiator = $this->getMockBuilder(AcceptNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var AcceptLanguageNegotiatorInterface|MockObject $acceptLanguageNegotiator */
        $acceptLanguageNegotiator = $this->getMockBuilder(AcceptLanguageNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var ContentTypeNegotiatorInterface|MockObject $contentTypeNegotiator */
        $contentTypeNegotiator = $this->getMockBuilder(ContentTypeNegotiatorInterface::class)->getMockForAbstractClass();

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::once())
            ->method('denormalize')
            ->with($object, $queryParams, $context)
            ->willReturn($object);

        $manager = new RequestManager(
            $acceptNegotiator,
            $acceptLanguageNegotiator,
            $contentTypeNegotiator,
            $deserializer
        );

        self::assertSame(
            $object,
            $manager->getDataFromRequestQuery($request, $object, $context)
        );
    }
}

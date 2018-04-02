<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Negotiation\AcceptLanguageNegotiatorInterface;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Chubbyphp\Negotiation\NegotiatedValueInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;

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
}

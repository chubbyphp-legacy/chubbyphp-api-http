<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\RequestManager
 */
final class RequestManagerTest extends TestCase
{
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

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::once())
            ->method('deserialize')
            ->with($object, $bodyString, 'application/json', $context)
            ->willReturn($object);

        $manager = new RequestManager($deserializer);

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

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockBuilder(DeserializerInterface::class)->getMockForAbstractClass();
        $deserializer->expects(self::once())
            ->method('denormalize')
            ->with($object, $queryParams, $context)
            ->willReturn($object);

        $manager = new RequestManager($deserializer);

        self::assertSame(
            $object,
            $manager->getDataFromRequestQuery($request, $object, $context)
        );
    }
}

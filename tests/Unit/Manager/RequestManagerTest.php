<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Manager;

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\Denormalizer\DenormalizerContextInterface;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\RequestManager
 *
 * @internal
 */
final class RequestManagerTest extends TestCase
{
    use MockByCallsTrait;

    public function testGetDataFromRequestQuery(): void
    {
        $object = new \stdClass();

        $queryParams = ['key' => 'value'];

        /** @var Request|MockObject $request */
        $request = $this->getMockByCalls(Request::class, [
            Call::create('getQueryParams')->with()->willReturn($queryParams),
        ]);

        /** @var DenormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(DenormalizerContextInterface::class);

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class, [
            Call::create('denormalize')->with($object, $queryParams, $context, '')->willReturn($object),
        ]);

        $manager = new RequestManager($deserializer);

        self::assertSame(
            $object,
            $manager->getDataFromRequestQuery($request, $object, $context)
        );
    }

    public function testGetDataFromRequestBody(): void
    {
        $object = new \stdClass();

        $bodyString = '{"key": "value}';

        /** @var StreamInterface|MockObject $body */
        $body = $this->getMockByCalls(StreamInterface::class, [
            Call::create('__toString')->with()->willReturn($bodyString),
        ]);

        /** @var Request|MockObject $request */
        $request = $this->getMockByCalls(Request::class, [
            Call::create('getBody')->with()->willReturn($body),
        ]);

        /** @var DenormalizerContextInterface|MockObject $context */
        $context = $this->getMockByCalls(DenormalizerContextInterface::class);

        /** @var DeserializerInterface|MockObject $deserializer */
        $deserializer = $this->getMockByCalls(DeserializerInterface::class, [
            Call::create('deserialize')
                ->with($object, $bodyString, 'application/json', $context, '')
                ->willReturn($object),
        ]);

        $manager = new RequestManager($deserializer);

        self::assertSame(
            $object,
            $manager->getDataFromRequestBody($request, $object, 'application/json', $context)
        );
    }
}

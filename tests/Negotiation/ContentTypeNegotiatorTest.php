<?php

namespace Chubbyphp\Tests\ApiHttp\Negotiation;

use Chubbyphp\ApiHttp\Negotiation\ContentTypeNegotiator;
use Chubbyphp\ApiHttp\Negotiation\NegotiatedValue;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @covers \Chubbyphp\ApiHttp\Negotiation\ContentTypeNegotiator
 */
final class ContentTypeNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutSupportedMimeTypes()
    {
        $negotiator = new ContentTypeNegotiator([]);

        self::assertNull($negotiator->negotiate($this->getRequest()));
    }

    public function testWithoutHeader()
    {
        $negotiator = new ContentTypeNegotiator(['application/json']);

        self::assertNull($negotiator->negotiate($this->getRequest()));
    }

    /**
     * @dataProvider getToNegotiateHeaders
     *
     * @param Request              $request
     * @param array                $supportedMimeTypes
     * @param NegotiatedValue|null $expectedContentType
     */
    public function testNegotiate(Request $request, array $supportedMimeTypes, NegotiatedValue $expectedContentType = null)
    {
        $negotiator = new ContentTypeNegotiator($supportedMimeTypes);

        self::assertEquals($expectedContentType, $negotiator->negotiate($request));
    }

    public function getToNegotiateHeaders(): array
    {
        return [
            [
                'request' => $this->getRequest('application/xml; charset=UTF-8'),
                'supportedMimeTypes' => ['application/json', 'application/xml', 'application/x-yaml'],
                'expectedContentType' => new NegotiatedValue('application/xml', ['charset' => 'UTF-8']),
            ],
            [
                'request' => $this->getRequest('application/xml; charset=UTF-8'),
                'supportedMimeTypes' => ['application/json'],
                'expectedContentType' => null,
            ],
            [
                'request' => $this->getRequest('application/xml; charset=UTF-8,'), // invalid format
                'supportedMimeTypes' => ['application/json', 'application/xml', 'application/x-yaml'],
                'expectedContentType' => null,
            ],
        ];
    }

    /**
     * @param string|null $acceptHeader
     *
     * @return Request
     */
    private function getRequest(string $acceptHeader = null): Request
    {
        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['hasHeader', 'getHeaderLine'])
            ->getMockForAbstractClass();

        $request->expects(self::any())->method('hasHeader')->with('Content-Type')->willReturn(null !== $acceptHeader);
        $request->expects(self::any())->method('getHeaderLine')->with('Content-Type')->willReturn($acceptHeader);

        return $request;
    }
}

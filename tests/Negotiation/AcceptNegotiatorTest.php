<?php

namespace Chubbyphp\Tests\ApiHttp\Negotiation;

use Chubbyphp\ApiHttp\Negotiation\AcceptNegotiator;
use Chubbyphp\ApiHttp\Negotiation\NegotiatedValue;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @covers \Chubbyphp\ApiHttp\Negotiation\AcceptNegotiator
 */
final class AcceptNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutSupportedMimeTypes()
    {
        $negotiator = new AcceptNegotiator([]);

        self::assertNull($negotiator->negotiate($this->getRequest()));
    }

    public function testWithoutHeader()
    {
        $negotiator = new AcceptNegotiator(['application/json']);

        self::assertNull($negotiator->negotiate($this->getRequest()));
    }

    /**
     * @dataProvider getToNegotiateHeaders
     *
     * @param Request              $request
     * @param array                $supportedMediaTypes
     * @param NegotiatedValue|null $expectedAccept
     */
    public function testNegotiate(Request $request, array $supportedMediaTypes, NegotiatedValue $expectedAccept = null)
    {
        $negotiator = new AcceptNegotiator($supportedMediaTypes);

        self::assertEquals($expectedAccept, $negotiator->negotiate($request));
    }

    public function getToNegotiateHeaders(): array
    {
        return [
            [
                'request' => $this->getRequest('text/html,   application/xhtml+xml,application/xml; q=0.9,*/*;q =0.8'),
                'supportedMediaTypes' => ['application/json', 'application/xml', 'application/x-yaml'],
                'expectedAccept' => new NegotiatedValue('application/xml', ['q' => '0.9']),
            ],
            [
                'request' => $this->getRequest('text/html,application/xhtml+xml ,application/xml; q=0.9 ,*/*;  q= 0.8'),
                'supportedMediaTypes' => ['application/json'],
                'expectedAccept' => new NegotiatedValue('application/json', ['q' => '0.8']),
            ],
            [
                'request' => $this->getRequest('*/json, */xml'), // cause */value is not a valid mime
                'supportedMediaTypes' => ['application/xml'],
                'expectedAccept' => null,
            ],
            [
                'request' => $this->getRequest('application/*;q=0.5, application/json'),
                'supportedMediaTypes' => ['application/xml', 'application/json'],
                'expectedAccept' => new NegotiatedValue('application/json', ['q' => '1.0']),
            ],
            [
                'request' => $this->getRequest('application/*, application/json;q=0.5'),
                'supportedMediaTypes' => ['application/xml', 'application/json'],
                'expectedAccept' => new NegotiatedValue('application/xml', ['q' => '1.0']),
            ],
            [
                'request' => $this->getRequest('application/*, application/json;q=0.5'),
                'supportedMediaTypes' => ['text/html'],
                'expectedAccept' => null,
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

        $request->expects(self::any())->method('hasHeader')->with('Accept')->willReturn(null !== $acceptHeader);
        $request->expects(self::any())->method('getHeaderLine')->with('Accept')->willReturn($acceptHeader);

        return $request;
    }
}

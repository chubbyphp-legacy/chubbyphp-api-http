<?php

namespace Chubbyphp\Tests\ApiHttp\Negotiation;

use Chubbyphp\ApiHttp\Negotiation\AcceptLanguageNegotiator;
use Chubbyphp\ApiHttp\Negotiation\NegotiatedValue;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @covers \Chubbyphp\ApiHttp\Negotiation\AcceptLanguageNegotiator
 */
final class AcceptLanguageNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutSupportedMimeTypes()
    {
        $negotiator = new AcceptLanguageNegotiator([]);

        self::assertNull($negotiator->negotiate($this->getRequest()));
    }

    public function testWithoutHeader()
    {
        $negotiator = new AcceptLanguageNegotiator(['en']);

        self::assertNull($negotiator->negotiate($this->getRequest()));
    }

    /**
     * @dataProvider getToNegotiateHeaders
     *
     * @param Request              $request
     * @param array                $supportedLocales
     * @param NegotiatedValue|null $expectedAcceptLanguage
     */
    public function testNegotiate(Request $request, array $supportedLocales, NegotiatedValue $expectedAcceptLanguage = null)
    {
        $negotiator = new AcceptLanguageNegotiator($supportedLocales);

        self::assertEquals($expectedAcceptLanguage, $negotiator->negotiate($request));
    }

    public function getToNegotiateHeaders(): array
    {
        return [
            [
                'request' => $this->getRequest('de,en-US;q=0.7,en;q=0.3'),
                'supportedMediaTypes' => ['en', 'de'],
                'expectedAcceptLanguage' => new NegotiatedValue('de', ['q' => '1.0']),
            ],
            [
                'request' => $this->getRequest('de,en;q=0.3'),
                'supportedMediaTypes' => ['en'],
                'expectedAcceptLanguage' => new NegotiatedValue('en', ['q' => '0.3']),
            ],
            [
                'request' => $this->getRequest('de,en;q=0.3'),
                'supportedMediaTypes' => ['fr'],
                'expectedAcceptLanguage' => null,
            ],
            [
                'request' => $this->getRequest('en-US;q=0.7,*;q=0.3'),
                'supportedMediaTypes' => ['de'],
                'expectedAcceptLanguage' => new NegotiatedValue('de', ['q' => '0.3']),
            ],
            [
                'request' => $this->getRequest('en; q=0.1, fr; q=0.4, fu; q=0.9, de; q=0.2'),
                'supportedMediaTypes' => ['de', 'fu', 'en'],
                'expectedAcceptLanguage' => new NegotiatedValue('fu', ['q' => '0.9']),
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

        $request->expects(self::any())->method('hasHeader')->with('Accept-Language')->willReturn(null !== $acceptHeader);
        $request->expects(self::any())->method('getHeaderLine')->with('Accept-Language')->willReturn($acceptHeader);

        return $request;
    }
}

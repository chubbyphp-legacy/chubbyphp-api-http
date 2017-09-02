<?php

namespace Chubbyphp\Tests\ApiHttp\Negotiation;

use Chubbyphp\ApiHttp\Negotiation\AcceptNegotiator;
use Chubbyphp\ApiHttp\Negotiation\NegotiatedValue;

/**
 * @covers \Chubbyphp\ApiHttp\Negotiation\AcceptNegotiator
 */
final class AcceptNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getToNegotiateHeaders
     *
     * @param string       $header
     * @param array        $supported
     * @param NegotiatedValue|null $expectedAccept
     */
    public function testNegotiate(string $header, array $supported, NegotiatedValue $expectedAccept = null)
    {
        $negotiator = new AcceptNegotiator();

        self::assertEquals($expectedAccept, $negotiator->negotiate($header, $supported));
    }

    public function getToNegotiateHeaders(): array
    {
        return [
            [
                'header' => 'text/html,   application/xhtml+xml,application/xml; q=0.9,*/*;q =0.8',
                'supported' => ['application/json', 'application/xml', 'application/x-yaml'],
                'expectedAccept' => new NegotiatedValue('application/xml', ['q' => '0.9']),
            ],
            [
                'header' => 'text/html,application/xhtml+xml   ,application/xml; q=0.9 ,*/*;    q= 0.8',
                'supported' => ['application/json'],
                'expectedAccept' => new NegotiatedValue('application/json', ['q' => '0.8']),
            ],
            [
                'header' => '*/json, */xml', // cause */value is not a valid mime
                'supported' => ['application/xml'],
                'expectedAccept' => null,
            ],
            [
                'header' => 'application/*;q=0.5, application/json',
                'supported' => ['application/xml', 'application/json'],
                'expectedAccept' => new NegotiatedValue('application/json', ['q' => '1.0']),
            ],
            [
                'header' => 'application/*, application/json;q=0.5',
                'supported' => ['application/xml', 'application/json'],
                'expectedAccept' => new NegotiatedValue('application/xml', ['q' => '1.0']),
            ],
            [
                'header' => 'application/*, application/json;q=0.5',
                'supported' => ['text/html'],
                'expectedAccept' => null,
            ],
        ];
    }
}



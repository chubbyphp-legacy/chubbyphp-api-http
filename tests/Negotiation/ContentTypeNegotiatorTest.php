<?php

namespace Chubbyphp\Tests\ApiHttp\Negotiation;

use Chubbyphp\ApiHttp\Negotiation\ContentTypeNegotiator;
use Chubbyphp\ApiHttp\Negotiation\NegotiatedValue;

/**
 * @covers \Chubbyphp\ApiHttp\Negotiation\ContentTypeNegotiator
 */
final class ContentTypeNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getToNegotiateHeaders
     *
     * @param string               $header
     * @param array                $supported
     * @param NegotiatedValue|null $expectedContentType
     */
    public function testNegotiate(string $header, array $supported, NegotiatedValue $expectedContentType = null)
    {
        $negotiator = new ContentTypeNegotiator();

        self::assertEquals($expectedContentType, $negotiator->negotiate($header, $supported));
    }

    public function getToNegotiateHeaders(): array
    {
        return [
            [
                'header' => 'application/xml; charset=UTF-8',
                'supported' => ['application/json', 'application/xml', 'application/x-yaml'],
                'expectedContentType' => new NegotiatedValue('application/xml', ['charset' => 'UTF-8']),
            ],
        ];
    }
}

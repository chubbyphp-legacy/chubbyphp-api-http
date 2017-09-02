<?php

namespace Chubbyphp\Tests\ApiHttp\Negotiation;

use Chubbyphp\ApiHttp\Negotiation\Content;
use Chubbyphp\ApiHttp\Negotiation\ContentNegotiator;

/**
 * @covers \Chubbyphp\ApiHttp\Negotiation\ContentNegotiator
 */
final class ContentNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getToNegotiateHeaders
     *
     * @param string       $header
     * @param array        $supported
     * @param Content|null $expectedContent
     */
    public function testNegotiate(string $header, array $supported, Content $expectedContent = null)
    {
        $negotiator = new ContentNegotiator();

        self::assertEquals($expectedContent, $negotiator->negotiate($header, $supported));
    }

    public function getToNegotiateHeaders(): array
    {
        return [
            [
                'header' => 'text/html,   application/xhtml+xml,application/xml; q=0.9,*/*;q =0.8',
                'supported' => ['application/json', 'application/xml', 'application/x-yaml'],
                'expectedContent' => new Content('application/xml', ['q' => '0.9']),
            ],
            [
                'header' => 'text/html,application/xhtml+xml   ,application/xml; q=0.9 ,*/*;    q= 0.8',
                'supported' => ['application/json'],
                'expectedContent' => new Content('application/json', ['q' => '0.8']),
            ],
            [
                'header' => '*/json, */xml',
                'supported' => ['application/xml'],
                'expectedContent' => new Content('application/xml', ['q' => '1.0']),
            ],
            [
                'header' => 'application/*;q=0.5, application/json',
                'supported' => ['application/xml', 'application/json'],
                'expectedContent' => new Content('application/json', ['q' => '1.0']),
            ],
            [
                'header' => 'application/*, application/json;q=0.5',
                'supported' => ['application/xml', 'application/json'],
                'expectedContent' => new Content('application/xml', ['q' => '1.0']),
            ],
            [
                'header' => 'application/*, application/json;q=0.5',
                'supported' => ['text/html'],
                'expectedContent' => null,
            ],
        ];
    }
}



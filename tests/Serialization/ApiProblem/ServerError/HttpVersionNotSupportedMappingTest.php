<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\HttpVersionNotSupported;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\HttpVersionNotSupportedMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\HttpVersionNotSupportedMapping
 */
final class HttpVersionNotSupportedMappingTest extends TestCase
{
    public function testGetClass()
    {
        $mapping = new HttpVersionNotSupportedMapping();

        self::assertSame(HttpVersionNotSupported::class, $mapping->getClass());
    }

    public function testGetNormalizationType()
    {
        $mapping = new HttpVersionNotSupportedMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings()
    {
        $mapping = new HttpVersionNotSupportedMapping();

        $fieldMappings = $mapping->getNormalizationFieldMappings('/');

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('type')->getMapping(),
            NormalizationFieldMappingBuilder::create('title')->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')->getMapping(),
            NormalizationFieldMappingBuilder::create('instance')->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings()
    {
        $mapping = new HttpVersionNotSupportedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings()
    {
        $mapping = new HttpVersionNotSupportedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

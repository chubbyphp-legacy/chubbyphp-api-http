<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\UnsupportedMediaTypeMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\UnsupportedMediaTypeMapping
 */
final class UnsupportedMediaTypeMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new UnsupportedMediaTypeMapping();

        self::assertSame(UnsupportedMediaType::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new UnsupportedMediaTypeMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
    {
        $mapping = new UnsupportedMediaTypeMapping();

        $fieldMappings = $mapping->getNormalizationFieldMappings('/');

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('type')->getMapping(),
            NormalizationFieldMappingBuilder::create('title')->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')->getMapping(),
            NormalizationFieldMappingBuilder::create('instance')->getMapping(),
            NormalizationFieldMappingBuilder::create('mediaType')->getMapping(),
            NormalizationFieldMappingBuilder::create('supportedMediaTypes')->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings(): void
    {
        $mapping = new UnsupportedMediaTypeMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new UnsupportedMediaTypeMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

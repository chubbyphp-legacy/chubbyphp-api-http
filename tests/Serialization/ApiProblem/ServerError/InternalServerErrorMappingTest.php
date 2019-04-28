<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InternalServerError;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\InternalServerErrorMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\InternalServerErrorMapping
 */
final class InternalServerErrorMappingTest extends TestCase
{
    public function testGetClass()
    {
        $mapping = new InternalServerErrorMapping();

        self::assertSame(InternalServerError::class, $mapping->getClass());
    }

    public function testGetNormalizationType()
    {
        $mapping = new InternalServerErrorMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings()
    {
        $mapping = new InternalServerErrorMapping();

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
        $mapping = new InternalServerErrorMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings()
    {
        $mapping = new InternalServerErrorMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

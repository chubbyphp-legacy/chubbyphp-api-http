<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InsufficientStorage;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\InsufficientStorageMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\InsufficientStorageMapping
 */
final class InsufficientStorageMappingTest extends TestCase
{
    public function testGetClass()
    {
        $mapping = new InsufficientStorageMapping();

        self::assertSame(InsufficientStorage::class, $mapping->getClass());
    }

    public function testGetNormalizationType()
    {
        $mapping = new InsufficientStorageMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings()
    {
        $mapping = new InsufficientStorageMapping();

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
        $mapping = new InsufficientStorageMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings()
    {
        $mapping = new InsufficientStorageMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

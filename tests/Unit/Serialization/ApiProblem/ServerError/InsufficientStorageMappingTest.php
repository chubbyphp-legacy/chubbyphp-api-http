<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InsufficientStorage;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\InsufficientStorageMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\InsufficientStorageMapping
 *
 * @internal
 */
final class InsufficientStorageMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new InsufficientStorageMapping();

        self::assertSame(InsufficientStorage::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new InsufficientStorageMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
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

    public function testGetNormalizationEmbeddedFieldMappings(): void
    {
        $mapping = new InsufficientStorageMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new InsufficientStorageMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

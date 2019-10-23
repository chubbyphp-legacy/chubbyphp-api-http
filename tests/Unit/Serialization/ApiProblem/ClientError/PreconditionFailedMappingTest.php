<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\PreconditionFailed;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\PreconditionFailedMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\PreconditionFailedMapping
 *
 * @internal
 */
final class PreconditionFailedMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new PreconditionFailedMapping();

        self::assertSame(PreconditionFailed::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new PreconditionFailedMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
    {
        $mapping = new PreconditionFailedMapping();

        $fieldMappings = $mapping->getNormalizationFieldMappings('/');

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('type')->getMapping(),
            NormalizationFieldMappingBuilder::create('title')->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')->getMapping(),
            NormalizationFieldMappingBuilder::create('instance')->getMapping(),
            NormalizationFieldMappingBuilder::create('failedPreconditions')->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings(): void
    {
        $mapping = new PreconditionFailedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new PreconditionFailedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotFound;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\NotFoundMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\NotFoundMapping
 *
 * @internal
 */
final class NotFoundMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new NotFoundMapping();

        self::assertSame(NotFound::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new NotFoundMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
    {
        $mapping = new NotFoundMapping();

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
        $mapping = new NotFoundMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new NotFoundMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

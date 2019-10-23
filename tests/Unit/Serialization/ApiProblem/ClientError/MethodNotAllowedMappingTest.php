<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\MethodNotAllowed;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\MethodNotAllowedMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\MethodNotAllowedMapping
 *
 * @internal
 */
final class MethodNotAllowedMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new MethodNotAllowedMapping();

        self::assertSame(MethodNotAllowed::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new MethodNotAllowedMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
    {
        $mapping = new MethodNotAllowedMapping();

        $fieldMappings = $mapping->getNormalizationFieldMappings('/');

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('type')->getMapping(),
            NormalizationFieldMappingBuilder::create('title')->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')->getMapping(),
            NormalizationFieldMappingBuilder::create('instance')->getMapping(),
            NormalizationFieldMappingBuilder::create('method')->getMapping(),
            NormalizationFieldMappingBuilder::create('allowedMethods')->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings(): void
    {
        $mapping = new MethodNotAllowedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new MethodNotAllowedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

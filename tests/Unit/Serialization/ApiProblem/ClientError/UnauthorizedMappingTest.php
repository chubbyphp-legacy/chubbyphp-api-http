<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Unauthorized;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\UnauthorizedMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\UnauthorizedMapping
 *
 * @internal
 */
final class UnauthorizedMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new UnauthorizedMapping();

        self::assertSame(Unauthorized::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new UnauthorizedMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
    {
        $mapping = new UnauthorizedMapping();

        $fieldMappings = $mapping->getNormalizationFieldMappings('/');

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('type')->getMapping(),
            NormalizationFieldMappingBuilder::create('title')->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')->getMapping(),
            NormalizationFieldMappingBuilder::create('instance')->getMapping(),
            NormalizationFieldMappingBuilder::create('authorization')->getMapping(),
            NormalizationFieldMappingBuilder::create('authorizationTypes')->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings(): void
    {
        $mapping = new UnauthorizedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new UnauthorizedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

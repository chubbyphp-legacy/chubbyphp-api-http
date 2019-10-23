<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\GatewayTimeout;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\GatewayTimeoutMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError\GatewayTimeoutMapping
 *
 * @internal
 */
final class GatewayTimeoutMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new GatewayTimeoutMapping();

        self::assertSame(GatewayTimeout::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new GatewayTimeoutMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
    {
        $mapping = new GatewayTimeoutMapping();

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
        $mapping = new GatewayTimeoutMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new GatewayTimeoutMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

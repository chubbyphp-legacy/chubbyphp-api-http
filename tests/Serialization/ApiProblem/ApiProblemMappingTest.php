<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem;

use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping
 */
final class ApiProblemMappingTest extends TestCase
{
    public function testGetClass(): void
    {
        $mapping = new class() extends AbstractApiProblemMapping {
            public function getClass(): string
            {
                return \stdClass::class;
            }
        };

        self::assertSame(\stdClass::class, $mapping->getClass());
    }

    public function testGetNormalizationType(): void
    {
        $mapping = new class() extends AbstractApiProblemMapping {
            public function getClass(): string
            {
                return \stdClass::class;
            }
        };

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings(): void
    {
        $mapping = new class() extends AbstractApiProblemMapping {
            public function getClass(): string
            {
                return \stdClass::class;
            }
        };

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
        $mapping = new class() extends AbstractApiProblemMapping {
            public function getClass(): string
            {
                return \stdClass::class;
            }
        };

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings(): void
    {
        $mapping = new class() extends AbstractApiProblemMapping {
            public function getClass(): string
            {
                return \stdClass::class;
            }
        };

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

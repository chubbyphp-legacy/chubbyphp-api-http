<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\LengthRequired;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\LengthRequiredMapping;
use Chubbyphp\Serialization\Accessor\MethodAccessor;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use Chubbyphp\Serialization\Normalizer\FieldNormalizer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\LengthRequiredMapping
 */
final class LengthRequiredMappingTest extends TestCase
{
    public function testGetClass()
    {
        $mapping = new LengthRequiredMapping();

        self::assertSame(LengthRequired::class, $mapping->getClass());
    }

    public function testGetNormalizationType()
    {
        $mapping = new LengthRequiredMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings()
    {
        $mapping = new LengthRequiredMapping();

        $fieldMappings = $mapping->getNormalizationFieldMappings('/');

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('type')
                ->setFieldNormalizer(new FieldNormalizer(new MethodAccessor('type')))
                ->getMapping(),
            NormalizationFieldMappingBuilder::create('title')
                ->setFieldNormalizer(new FieldNormalizer(new MethodAccessor('title')))
                ->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')
                ->setFieldNormalizer(new FieldNormalizer(new MethodAccessor('detail')))
                ->getMapping(),
            NormalizationFieldMappingBuilder::create('instance')
                ->setFieldNormalizer(new FieldNormalizer(new MethodAccessor('instance')))
                ->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings()
    {
        $mapping = new LengthRequiredMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings()
    {
        $mapping = new LengthRequiredMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

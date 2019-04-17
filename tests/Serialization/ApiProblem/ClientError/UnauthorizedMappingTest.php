<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Unauthorized;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\UnauthorizedMapping;
use Chubbyphp\Serialization\Accessor\MethodAccessor;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use Chubbyphp\Serialization\Normalizer\FieldNormalizer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\UnauthorizedMapping
 */
final class UnauthorizedMappingTest extends TestCase
{
    public function testGetClass()
    {
        $mapping = new UnauthorizedMapping();

        self::assertSame(Unauthorized::class, $mapping->getClass());
    }

    public function testGetNormalizationType()
    {
        $mapping = new UnauthorizedMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings()
    {
        $mapping = new UnauthorizedMapping();

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
            NormalizationFieldMappingBuilder::create('authorizationTypes')
                ->setFieldNormalizer(new FieldNormalizer(new MethodAccessor('authorizationTypes')))
                ->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings()
    {
        $mapping = new UnauthorizedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings()
    {
        $mapping = new UnauthorizedMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

<?php

namespace Chubbyphp\Tests\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestEntityTooLarge;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\RequestEntityTooLargeMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError\RequestEntityTooLargeMapping
 */
final class RequestEntityTooLargeMappingTest extends TestCase
{
    public function testGetClass()
    {
        $mapping = new RequestEntityTooLargeMapping();

        self::assertSame(RequestEntityTooLarge::class, $mapping->getClass());
    }

    public function testGetNormalizationType()
    {
        $mapping = new RequestEntityTooLargeMapping();

        self::assertSame('apiProblem', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings()
    {
        $mapping = new RequestEntityTooLargeMapping();

        $fieldMappings = $mapping->getNormalizationFieldMappings('/');

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('type')->getMapping(),
            NormalizationFieldMappingBuilder::create('title')->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')->getMapping(),
            NormalizationFieldMappingBuilder::create('instance')->getMapping(),
            NormalizationFieldMappingBuilder::create('maxContentLength')->getMapping(),
        ], $fieldMappings);
    }

    public function testGetNormalizationEmbeddedFieldMappings()
    {
        $mapping = new RequestEntityTooLargeMapping();

        $embeddedFieldMappings = $mapping->getNormalizationEmbeddedFieldMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }

    public function testGetNormalizationLinkMappings()
    {
        $mapping = new RequestEntityTooLargeMapping();

        $embeddedFieldMappings = $mapping->getNormalizationLinkMappings('/');

        self::assertEquals([], $embeddedFieldMappings);
    }
}

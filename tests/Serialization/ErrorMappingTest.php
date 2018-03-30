<?php

namespace Chubbyphp\Tests\ApiHttp\Error;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Serialization\ErrorMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ErrorMapping
 */
final class ErrorMappingTest extends TestCase
{
    public function testGetClass()
    {
        $mapping = new ErrorMapping();

        self::assertSame(Error::class, $mapping->getClass());
    }

    public function testGetNormalizationType()
    {
        $mapping = new ErrorMapping();

        self::assertSame('error', $mapping->getNormalizationType());
    }

    public function testGetNormalizationFieldMappings()
    {
        $mapping = new ErrorMapping();

        self::assertEquals([
            NormalizationFieldMappingBuilder::create('scope')->getMapping(),
            NormalizationFieldMappingBuilder::create('key')->getMapping(),
            NormalizationFieldMappingBuilder::create('detail')->getMapping(),
            NormalizationFieldMappingBuilder::create('reference')->getMapping(),
            NormalizationFieldMappingBuilder::create('arguments')->getMapping(),
        ], $mapping->getNormalizationFieldMappings('path'));
    }

    public function testGetNormalizationEmbeddedFieldMappings()
    {
        $mapping = new ErrorMapping();

        self::assertEquals([], $mapping->getNormalizationEmbeddedFieldMappings('path'));
    }

    public function testGetNormalizationLinkMappings()
    {
        $mapping = new ErrorMapping();

        self::assertEquals([], $mapping->getNormalizationLinkMappings('path'));
    }
}

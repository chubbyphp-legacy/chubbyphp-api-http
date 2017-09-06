<?php

namespace Chubbyphp\Tests\ApiHttp\Error;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\ApiHttp\Serialization\ErrorMapping;
use Chubbyphp\Serialization\Mapping\FieldMapping;

/**
 * @covers \Chubbyphp\ApiHttp\Serialization\ErrorMapping
 */
final class ErrorMappingTest extends \PHPUnit_Framework_TestCase
{
    public function testGetClass()
    {
        $mapping = new ErrorMapping();

        self::assertSame(Error::class, $mapping->getClass());
    }

    public function testGetType()
    {
        $mapping = new ErrorMapping();

        self::assertSame('error', $mapping->getType());
    }

    public function testGetFieldMapping()
    {
        $mapping = new ErrorMapping();

        self::assertEquals([
            new FieldMapping('scope'),
            new FieldMapping('key'),
            new FieldMapping('detail'),
            new FieldMapping('reference'),
            new FieldMapping('arguments'),
        ], $mapping->getFieldMappings());
    }

    public function testGetEmbeddedFieldMappings()
    {
        $mapping = new ErrorMapping();

        self::assertEquals([], $mapping->getEmbeddedFieldMappings());
    }

    public function testGetLinkMappings()
    {
        $mapping = new ErrorMapping();

        self::assertEquals([], $mapping->getLinkMappings());
    }
}

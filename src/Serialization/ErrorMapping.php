<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization;

use Chubbyphp\ApiHttp\Error\Error;
use Chubbyphp\Serialization\Mapping\FieldMapping;
use Chubbyphp\Serialization\Mapping\FieldMappingInterface;
use Chubbyphp\Serialization\Mapping\LinkMappingInterface;
use Chubbyphp\Serialization\Mapping\ObjectMappingInterface;

final class ErrorMapping implements ObjectMappingInterface
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return Error::class;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'error';
    }

    /**
     * @return FieldMappingInterface[]
     */
    public function getFieldMappings(): array
    {
        return [
            new FieldMapping('scope'),
            new FieldMapping('key'),
            new FieldMapping('detail'),
            new FieldMapping('reference'),
            new FieldMapping('arguments'),
        ];
    }

    /**
     * @return FieldMappingInterface[]
     */
    public function getEmbeddedFieldMappings(): array
    {
        return [];
    }

    /**
     * @return LinkMappingInterface[]
     */
    public function getLinkMappings(): array
    {
        return [];
    }
}

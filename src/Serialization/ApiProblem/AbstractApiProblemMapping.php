<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem;

use Chubbyphp\Serialization\Accessor\MethodAccessor;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingInterface;
use Chubbyphp\Serialization\Mapping\NormalizationLinkMappingInterface;
use Chubbyphp\Serialization\Mapping\NormalizationObjectMappingInterface;
use Chubbyphp\Serialization\Normalizer\FieldNormalizer;

abstract class AbstractApiProblemMapping implements NormalizationObjectMappingInterface
{
    /**
     * @return string
     */
    public function getNormalizationType(): string
    {
        return 'apiProblem';
    }

    /**
     * @param string $path
     *
     * @return NormalizationFieldMappingInterface[]
     */
    public function getNormalizationFieldMappings(string $path): array
    {
        return [
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
        ];
    }

    /**
     * @param string $path
     *
     * @return NormalizationFieldMappingInterface[]
     */
    public function getNormalizationEmbeddedFieldMappings(string $path): array
    {
        return [];
    }

    /**
     * @param string $path
     *
     * @return NormalizationLinkMappingInterface[]
     */
    public function getNormalizationLinkMappings(string $path): array
    {
        return [];
    }
}

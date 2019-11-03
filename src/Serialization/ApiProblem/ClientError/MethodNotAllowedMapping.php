<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\MethodNotAllowed;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingInterface;

final class MethodNotAllowedMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return MethodNotAllowed::class;
    }

    /**
     * @return NormalizationFieldMappingInterface[]
     */
    public function getNormalizationFieldMappings(string $path): array
    {
        $fieldMappings = parent::getNormalizationFieldMappings($path);

        $fieldMappings[] = NormalizationFieldMappingBuilder::create('method')->getMapping();
        $fieldMappings[] = NormalizationFieldMappingBuilder::create('allowedMethods')->getMapping();

        return $fieldMappings;
    }
}

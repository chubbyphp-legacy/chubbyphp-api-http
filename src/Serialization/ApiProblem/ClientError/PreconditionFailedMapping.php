<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\PreconditionFailed;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingInterface;

final class PreconditionFailedMapping extends AbstractApiProblemMapping
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return PreconditionFailed::class;
    }

    /**
     * @param string $path
     *
     * @return NormalizationFieldMappingInterface[]
     */
    public function getNormalizationFieldMappings(string $path): array
    {
        $fieldMappings = parent::getNormalizationFieldMappings($path);

        $fieldMappings[] = NormalizationFieldMappingBuilder::create('failedPreconditions')->getMapping();

        return $fieldMappings;
    }
}

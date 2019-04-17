<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Unauthorized;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;
use Chubbyphp\Serialization\Accessor\MethodAccessor;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingBuilder;
use Chubbyphp\Serialization\Mapping\NormalizationFieldMappingInterface;
use Chubbyphp\Serialization\Normalizer\FieldNormalizer;

final class UnauthorizedMapping extends AbstractApiProblemMapping
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return Unauthorized::class;
    }

    /**
     * @param string $path
     *
     * @return NormalizationFieldMappingInterface[]
     */
    public function getNormalizationFieldMappings(string $path): array
    {
        $fieldMappings = parent::getNormalizationFieldMappings($path);

        $fieldMappings[] = NormalizationFieldMappingBuilder::create('authorizationTypes')
            ->setFieldNormalizer(new FieldNormalizer(new MethodAccessor('authorizationTypes')))
            ->getMapping();

        return $fieldMappings;
    }
}

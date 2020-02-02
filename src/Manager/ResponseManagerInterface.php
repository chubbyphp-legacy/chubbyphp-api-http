<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponseManagerInterface
{
    /**
     * @param object $object
     */
    public function create(
        $object,
        string $accept,
        int $status = 200,
        ?NormalizerContextInterface $context = null
    ): ResponseInterface;

    public function createEmpty(string $accept, int $status = 204): ResponseInterface;

    public function createRedirect(string $location, int $status = 307): ResponseInterface;

    public function createFromApiProblem(
        ApiProblemInterface $apiProblem,
        string $accept,
        ?NormalizerContextInterface $context = null
    ): ResponseInterface;
}

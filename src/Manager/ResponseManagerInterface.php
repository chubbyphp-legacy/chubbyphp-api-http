<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\HttpException\HttpExceptionInterface;
use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponseManagerInterface
{
    public function create(
        object $object,
        string $accept,
        int $status = 200,
        ?NormalizerContextInterface $context = null
    ): ResponseInterface;

    public function createEmpty(string $accept, int $status = 204): ResponseInterface;

    public function createRedirect(string $location, int $status = 307): ResponseInterface;

    public function createFromHttpException(
        HttpExceptionInterface $httpException,
        string $accept,
    ): ResponseInterface;
}

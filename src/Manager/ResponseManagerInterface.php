<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Chubbyphp\Serialization\Normalizer\NormalizerContextInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

interface ResponseManagerInterface
{
    /**
     * @param object                          $object
     * @param string                          $accept
     * @param int                             $status
     * @param NormalizerContextInterface|null $context
     *
     * @return Response
     */
    public function create(
        $object,
        string $accept,
        int $status = 200,
        NormalizerContextInterface $context = null
    ): Response;

    /**
     * @param string $accept
     * @param int    $status
     *
     * @return Response
     */
    public function createEmpty(string $accept, int $status = 204): Response;

    /**
     * @param string $location
     * @param int    $status
     *
     * @return Response
     */
    public function createRedirect(string $location, int $status = 307): Response;

    /**
     * @param ApiProblemInterface        $apiProblem
     * @param string                     $accept
     * @param NormalizerContextInterface $context
     *
     * @return Response
     */
    public function createFromApiProblem(
        ApiProblemInterface $apiProblem,
        string $accept,
        NormalizerContextInterface $context = null
    ): Response;
}

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Psr\Http\Message\ServerRequestInterface as Request;

interface RequestManagerInterface
{
    /**
     * @param Request $request
     *
     * @return string|null
     */
    public function getAccept(Request $request);

    /**
     * @param Request $request
     *
     * @return string|null
     */
    public function getAcceptLanguage(Request $request);

    /**
     * @param Request $request
     *
     * @return string|null
     */
    public function getContentType(Request $request);

    /**
     * @param Request       $request
     * @param object|string $object
     *
     * @return object
     */
    public function getDataFromRequestBody(Request $request, $object);

    /**
     * @param Request       $request
     * @param object|string $object
     *
     * @return object
     */
    public function getDataFromRequestQuery(Request $request, $object);
}

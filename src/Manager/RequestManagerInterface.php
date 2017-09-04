<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Manager;

use Psr\Http\Message\ServerRequestInterface as Request;

interface RequestManagerInterface
{
    /**
     * @param Request     $request
     * @param string|null $default
     *
     * @return string|null
     */
    public function getAccept(Request $request, string $default = null);

    /**
     * @param Request     $request
     * @param string|null $default
     *
     * @return string|null
     */
    public function getAcceptLanguage(Request $request, string $default = null);

    /**
     * @param Request     $request
     * @param string|null $default
     *
     * @return string|null
     */
    public function getContentType(Request $request, string $default = null);

    /**
     * @param Request       $request
     * @param object|string $object
     * @param string        $contentType
     *
     * @return object|null
     */
    public function getDataFromRequestBody(Request $request, $object, string $contentType);

    /**
     * @param Request       $request
     * @param object|string $object
     *
     * @return object
     */
    public function getDataFromRequestQuery(Request $request, $object);
}

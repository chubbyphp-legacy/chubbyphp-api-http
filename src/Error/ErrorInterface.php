<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Error;

interface ErrorInterface
{
    const SCOPE_METHOD = 'method';
    const SCOPE_RESOURCE = 'resource';
    const SCOPE_QUERY = 'query';
    const SCOPE_HEADER = 'header';
    const SCOPE_BODY = 'body';
    const SCOPE_SERVER = 'server';

    /**
     * @return string
     */
    public function getScope(): string;

    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return string|null
     */
    public function getDetail();

    /**
     * @return string|null
     */
    public function getReference();

    /**
     * @return array
     */
    public function getArguments(): array;
}

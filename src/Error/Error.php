<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Error;

final class Error
{
    /**
     * @var string|null
     */
    private $scope;

    const SCOPE_METHOD = 'method';
    const SCOPE_RESOURCE = 'resource';
    const SCOPE_QUERY = 'query';
    const SCOPE_HEADER = 'header';
    const SCOPE_BODY = 'body';
    const SCOPE_SERVER = 'server';

    /**
     * Identifier.
     *
     * @var string
     */
    private $key;

    /**
     * Technical error description.
     *
     * @var string|null
     */
    private $detail;

    /**
     * Reference to the error causing form field, parameter, value, header, etc.
     *
     * @var string|null
     */
    private $reference;

    /**
     * Parameters which can be used by client in order to display a expressive error message.
     *
     * @var array|null
     */
    private $arguments;

    /**
     * @param string|null $scope
     * @param string      $key
     * @param string|null $detail
     * @param string|null $reference
     * @param array       $arguments
     */
    public function __construct(
        string $scope,
        string $key,
        string $detail = null,
        string $reference = null,
        array $arguments = []
    ) {
        $this->scope = $scope;
        $this->key = $key;
        $this->detail = $detail;
        $this->reference = $reference;
        $this->arguments = $arguments;
    }

    /**
     * @return null|string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string|null
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @return string|null
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return array|null
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}

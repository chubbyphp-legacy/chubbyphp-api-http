<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Error;

final class Error implements ErrorInterface
{
    /**
     * @var string
     */
    private $scope;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string|null
     */
    private $detail;

    /**
     * @var string|null
     */
    private $reference;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @param string      $scope
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
     * @return string
     */
    public function getScope(): string
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
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}

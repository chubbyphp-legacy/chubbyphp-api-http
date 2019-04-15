<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem;

abstract class AbstractApiProblem implements ApiProblemInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $detail;

    /**
     * @var string|null
     */
    private $instance;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }

    /**
     * @param string $title
     *
     * @return ApiProblemInterface
     */
    public function withTitle(string $title): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->title = $title;

        return $clone;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string|null $detail
     *
     * @return ApiProblemInterface
     */
    public function withDetail(string $detail = null): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->detail = $detail;

        return $clone;
    }

    /**
     * @return string|null
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string|null $instance
     *
     * @return ApiProblemInterface
     */
    public function withInstance(string $instance = null): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->instance = $instance;

        return $clone;
    }

    /**
     * @return string|null
     */
    public function getInstance()
    {
        return $this->instance;
    }
}

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
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(string $title, string $detail = null, string $instance = null)
    {
        $this->title = $title;
        $this->detail = $detail;
        $this->instance = $instance;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
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
    public function getInstance()
    {
        return $this->instance;
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem;

abstract class AbstractApiProblem implements ApiProblemInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $detail;

    /**
     * @var string|null
     */
    protected $instance;

    /**
     * @param string      $type
     * @param int         $status
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(
        string $type,
        int $status,
        string $title,
        string $detail = null,
        string $instance = null
    ) {
        $this->type = $type;
        $this->status = $status;
        $this->title = $title;
        $this->detail = $detail;
        $this->instance = $instance;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
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

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [];
    }
}

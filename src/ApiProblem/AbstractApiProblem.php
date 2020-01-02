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
     * @var string|null
     */
    protected $detail;

    /**
     * @var string|null
     */
    protected $instance;

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

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function getInstance(): ?string
    {
        return $this->instance;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return [];
    }
}

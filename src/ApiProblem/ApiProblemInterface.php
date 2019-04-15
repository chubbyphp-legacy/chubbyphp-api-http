<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem;

interface ApiProblemInterface
{
    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $title
     *
     * @return self
     */
    public function withTitle(string $title): self;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string|null $detail
     *
     * @return self
     */
    public function withDetail(string $detail = null): self;

    /**
     * @return string|null
     */
    public function getDetail();

    /**
     * @param string|null $instance
     *
     * @return self
     */
    public function withInstance(string $instance = null): self;

    /**
     * @return string|null
     */
    public function getInstance();
}

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
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string|null
     */
    public function getDetail();

    /**
     * @return string|null
     */
    public function getInstance();

    /**
     * @return array
     */
    public function getHeaders(): array;
}

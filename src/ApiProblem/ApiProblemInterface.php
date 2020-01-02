<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem;

interface ApiProblemInterface
{
    public function getStatus(): int;

    public function getType(): string;

    public function getTitle(): string;

    public function getDetail(): ?string;

    public function getInstance(): ?string;

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array;
}

<?php

namespace App\Task\Application\Category;

readonly class GetCategoryResponse
{
    public function __construct(private bool $status, private array $data = []) {}

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getData(): array
    {
        return $this->data;
    }
}

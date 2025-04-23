<?php

namespace App\Task\Application\Category;

readonly class CreateCategoryResponse
{
    public function __construct(private bool $status, private array $errors = []) {}

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

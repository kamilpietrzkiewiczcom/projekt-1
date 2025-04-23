<?php

namespace App\Task\Application\Category;

use App\Task\Domain\CategoryCollection;

readonly class ReadAllCategoriesResponse
{
    public function __construct(private bool $status, private array $data, private CategoryCollection $categoryCollection) {}

    public function getData(): array
    {
        return $this->data;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getCategories(): CategoryCollection
    {
        return $this->categoryCollection;
    }
}

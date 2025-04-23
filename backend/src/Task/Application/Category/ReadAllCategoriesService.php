<?php

namespace App\Task\Application\Category;

use App\Task\Domain\CategoryCollection;
use App\Task\Domain\CategoryRepository;

readonly class ReadAllCategoriesService
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function get(): ReadAllCategoriesResponse
    {
        try {
            $categories = $this->categoryRepository->getAll();
            return new ReadAllCategoriesResponse(true, [], $categories);
        } catch (\Throwable $e) {
            return new ReadAllCategoriesResponse(false, ["Unknown error"], new CategoryCollection());
        }
    }
}

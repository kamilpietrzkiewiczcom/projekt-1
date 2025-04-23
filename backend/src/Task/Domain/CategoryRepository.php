<?php

namespace App\Task\Domain;

use Symfony\Component\Uid\Uuid;

interface CategoryRepository
{
    public function getNextIdentifier(): Uuid;
    public function persist(Category $product): void;
    public function getAll(): CategoryCollection; // for simplicity - usually there should be pagination here
                                                  // or return iterator that iterates over the repository
    public function removeCategory(Uuid $categoryId): void;
    public function getCategoryById(Uuid $id): Category;
}

<?php

namespace App\Task\Application\Category;

use App\Task\Adapter\Controller\Category\CreateCategoryRequest;
use App\Task\Domain\Category;
use App\Task\Domain\CategoryCode;
use App\Task\Domain\CategoryRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Uid\Uuid;
use Throwable;

readonly class DeleteCategoryService
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function removeCategory(Uuid $categoryId): DeleteCategoryResponse
    {
        try {
            $this->categoryRepository->removeCategory($categoryId);
            return new DeleteCategoryResponse(true);
        } catch (Throwable $e) {
            return new DeleteCategoryResponse(false, ['UNKNOWN ERROR']);
        }
    }
}

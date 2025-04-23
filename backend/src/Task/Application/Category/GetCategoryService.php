<?php

namespace App\Task\Application\Category;

use App\Task\Adapter\Controller\Category\CreateCategoryRequest;
use App\Task\Domain\Category;
use App\Task\Domain\CategoryCode;
use App\Task\Domain\CategoryRepository;
use App\Task\Domain\Exceptions\Category\CategoryDoesNotExistException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Uid\Uuid;
use Throwable;

readonly class GetCategoryService
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function get(Uuid $categoryId): GetCategoryResponse
    {
        try {
            $category = $this->categoryRepository->getCategoryById($categoryId);
            return new GetCategoryResponse(true, ["category" => $category]);
        } catch (CategoryDoesNotExistException) {
            return new GetCategoryResponse(false, ['Category does not exists']);
        } catch (Throwable $e) {
            return new GetCategoryResponse(false, ['Unknown error']);
        }
    }
}
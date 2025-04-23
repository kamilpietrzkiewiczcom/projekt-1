<?php

namespace App\Task\Application\Category;

use App\Task\Adapter\Controller\Category\UpdateCategoryRequest;
use App\Task\Domain\CategoryRepository;
use App\Task\Domain\Exceptions\Category\CategoryDoesNotExistException;
use Symfony\Component\Uid\Uuid;
use Throwable;

readonly class UpdateCategoryService
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function updateCategory(UpdateCategoryRequest $request): UpdateCategoryResponse
    {
        try {
            $category = $this->categoryRepository->getCategoryById(Uuid::fromString($request->getId()));
            $category->updateCode($request->getCode());
            $this->categoryRepository->persist($category);
            return new UpdateCategoryResponse(true, []);
        } catch (CategoryDoesNotExistException) {
            return new UpdateCategoryResponse(false, ["Category does not exists"]);
        } catch (Throwable $e) {
            return new UpdateCategoryResponse(false, ["Unknown error"]);
        }
    }
}

<?php

namespace App\Task\Application\Category;

use App\Task\Adapter\Controller\Category\CreateCategoryRequest;
use App\Task\Domain\Category;
use App\Task\Domain\CategoryCode;
use App\Task\Domain\CategoryRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Throwable;

readonly class CreateNewCategoryService
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function create(CreateCategoryRequest $request): CreateCategoryResponse
    {
        try {
            $id = $this->categoryRepository->getNextIdentifier();
            $code = new CategoryCode($request->getCode());
            $category = new Category(
                $id,
                $code,
            );

            $this->categoryRepository->persist($category);

            return new CreateCategoryResponse(true);
        } catch (UniqueConstraintViolationException) {
            return new CreateCategoryResponse(false, ['Unique constraint violation. Category already exists.']);
        } catch (Throwable $e) {
            return new CreateCategoryResponse(false, ['Unknown error']);
        }
    }
}
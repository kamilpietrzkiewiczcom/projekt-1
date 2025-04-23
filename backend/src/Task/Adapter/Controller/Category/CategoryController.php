<?php

namespace App\Task\Adapter\Controller\Category;

use App\Task\Application\Category\CreateNewCategoryService;
use App\Task\Application\Category\DeleteCategoryService;
use App\Task\Application\Category\GetCategoryService;
use App\Task\Application\Category\ReadAllCategoriesService;
use App\Task\Application\Category\UpdateCategoryService;
use App\Task\Domain\CategoryCollection;
use App\Task\Domain\Exceptions\Category\CategoryDoesNotExistException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;
use Throwable;

class CategoryController extends AbstractController
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly CreateNewCategoryService $createNewCategoryService,
        private readonly GetCategoryService $readCategoryService,
        private readonly ReadAllCategoriesService $readAllCategoriesService,
        private readonly UpdateCategoryService $updateCategoryService,
        private readonly DeleteCategoryService $deleteCategoryService,
    ) {}

    #[Route("/category", name: "create_category", methods: ["POST"])]
    public function createCategory(CreateCategoryRequest $request): JsonResponse
    {
        try {
            if (!$request->isValid()) {
                return new JsonResponse([
                    'isError' => true,
                    'msg' => "Validation errors",
                    "data" => $request->getValidationErrors()
                ]);
            }

            $response = $this->createNewCategoryService->create($request);

            return new JsonResponse(
                ['isError' => !$response->getStatus(), 'msg' => "OK", "data" => $response->getErrors()],
                !$response->getStatus() ? 500 : 200
            );
        } catch (Throwable) {
            return new JsonResponse(['isError' => true, 'msg' => "UNKNOWN ERROR", "data" => []], 500);
        }
    }

    #[Route("/category", name: "update_category", methods: ["PUT"])]
    public function updateCategory(UpdateCategoryRequest $request): JsonResponse
    {
        try {
            $this->updateCategoryService->updateCategory($request);
            return new JsonResponse(
                ['isError' => false, 'msg' => "OK", "data" => ["Category updated"]], 200
            );
        } catch (CategoryDoesNotExistException) {
            return new JsonResponse(['isError' => true, 'msg' => "ERROR", "data" => ["Category does not exists"]], 400);
        } catch (Throwable $e) {
            return new JsonResponse(['isError' => true, 'msg' => "UNKNOWN ERROR", "data" => []], 500);
        }
    }

    #[Route("/category/{categoryId}", name: "delete_category", methods: ["DELETE"])]
    public function deleteCategory(Uuid $categoryId): JsonResponse
    {
        /**
         * here we do hard delete, usually I would do soft delete
         */

        try {
            $response = $this->deleteCategoryService->removeCategory($categoryId);
            return new JsonResponse(['isError' => !$response->getStatus(), 'msg' => "OK", "data" => ["Category deleted"]]);
        } catch (Throwable $e) {
            var_dump($e->getMessage());
            die;

            return new JsonResponse(
                ['isError' => true, 'msg' => "ERROR", "data" => ["Category can`t be deleted"]],
                500
            );
        }
    }

    #[Route("/category", name: "get_category", methods: ["GET"])]
    public function getCategory(Uuid $categoryId): JsonResponse
    {
        try {
            $response = $this->readCategoryService->get($categoryId);
            return new JsonResponse([
                'isError' => !$response->getStatus(),
                'msg' => !$response->getStatus() ? "OK" : "ERROR",
                "data" => ["Category deleted"]
            ],  !$response->getStatus() ? "200" : "400");
        } catch (Throwable $e) {
            return new JsonResponse(
                ['isError' => true, 'msg' => "ERROR", "data" => ["Category can`t be deleted"]],
                500
            );
        }
    }

    #[Route("/categories", name: "get_categories",methods: ["GET"])]
    public function readAll(): JsonResponse
    {
        try {
            $serviceResponse = $this->readAllCategoriesService->get();
            $categories = $serviceResponse->getCategories();
            $data = $this->getCategoriesDataWithHateoas($categories);
            return new JsonResponse(['isError
            ' => false, 'msg' => "OK", "data" => $data]);
        } catch (Throwable $e) {
            return new JsonResponse(['isError' => true, 'msg' => "ERROR", "data" => ["Can`t get categories."]], 500);
        }
    }

    private function getCategoriesDataWithHateoas(CategoryCollection $categoryCollection): array
    {
        $data = [];
        $categoryCollection->rewind();
        while ($categoryCollection->valid()) {
            $category = $categoryCollection->current();
            $data[] = [
                'id' => $category->getId(),
                'code' => $category->getCode(),
                '$hrefs' => [
                    'create' => $this->urlGenerator->generate('create_category'),
                    'read' => $this->urlGenerator->generate('get_category', ['id' => $category->getId()]),
                    'update' => $this->urlGenerator->generate('update_category'),
                    'delete' => $this->urlGenerator->generate('delete_category', ['categoryId' => $category->getId()]),
                ]
            ];
            $categoryCollection->next();
        }
        return $data;
    }
}

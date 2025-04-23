<?php

namespace App\Task\Adapter\Controller\Product;

use App\Task\Application\Product\CreateNewProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class ProductController extends AbstractController
{
    public function __construct(private readonly CreateNewProductService $createNewProductService) {}

    #[Route("/product", methods: ["POST"])]
    public function create(CreateProductRequest $request): JsonResponse
    {
        try {
            if (!$request->isValid()) {
                return new JsonResponse([
                    'isError' => true,
                    'msg' => "Validation errors",
                    "data" => $request->getValidationErrors()
                ]);
            }

            $this->createNewProductService->create($request);
            return new JsonResponse(['isError' => false, 'msg' => "OK", "data" => []]);
        } catch (Throwable $e) {
            return new JsonResponse(['isError' => true, 'msg' => "Unknown error", "data" => []]);
        }
    }
}
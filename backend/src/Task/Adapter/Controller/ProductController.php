<?php

namespace App\Task\Adapter\Controller;

use App\Task\Domain\Product;
use App\Task\Domain\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route("/product")]
class ProductController extends AbstractController
{
    public function __construct(private readonly ProductRepository $productRepository) {}

    public function create(): JsonResponse
    {
        try {

            $product = new Product();
            $this->productRepository->persist($product);
            return new JsonResponse(['isError' => false, 'msg' => "OK", "data" => []]);
        } catch () {
            return new JsonResponse(['isError' => true, 'msg' => "Product needs at least one category", "data" => []]);
        } catch (Throwable $e) {
            return new JsonResponse(['isError' => true, 'msg' => "Unknown error", "data" => []]);
        }
    }
}
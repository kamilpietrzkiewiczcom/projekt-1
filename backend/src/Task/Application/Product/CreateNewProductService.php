<?php

namespace App\Task\Application\Product;

use App\Task\Adapter\Controller\Product\CreateProductRequest;
use App\Task\Domain\Product;
use App\Task\Domain\ProductPrice;
use App\Task\Domain\ProductRepository;
use App\Task\Domain\ProductTitle;

readonly class CreateNewProductService
{
    public function __construct(private ProductRepository $productRepository) {}

    public function create(CreateProductRequest $request): CreateProductResponse
    {
        try {
            $id = $this->productRepository->getNextIdentifier();
            $title = new ProductTitle($request->getTitle());
            $price = new ProductPrice($request->getAmount());
            $product = new Product(
                $id,
                $title,
                $price
            );

            $this->productRepository->persist($product);

            return new CreateProductResponse(true);
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
        }
    }
}

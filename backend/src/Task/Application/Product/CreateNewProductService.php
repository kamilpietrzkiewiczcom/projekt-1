<?php

namespace App\Task\Application\Product;

use App\Task\Adapter\Controller\Product\CreateProductRequest;
use App\Task\Domain\CategoryRepository;
use App\Task\Domain\Product;
use App\Task\Domain\ProductPrice;
use App\Task\Domain\ProductRepository;
use App\Task\Domain\ProductTitle;
use Symfony\Component\Uid\Uuid;

readonly class CreateNewProductService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository
    ) {}

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

            $categories = $request->getCategories();

            foreach ($categories as $category) {
                $product->addCategory($this->categoryRepository->getReference(Uuid::fromString($category)));
            }

            $this->productRepository->persist($product);

            return new CreateProductResponse(true);
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
            die;
        }

    }
}

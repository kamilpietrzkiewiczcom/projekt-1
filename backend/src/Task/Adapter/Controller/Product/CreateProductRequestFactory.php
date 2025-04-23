<?php

namespace App\Task\Adapter\Controller\Product;

use RuntimeException;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class CreateProductRequestFactory
{
    public function __construct(private RequestStack $requestStack) {}

    public function getRequest(): CreateProductRequest
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {throw new RuntimeException("Can`t get request for CreateProductRequest.");}
        return new CreateProductRequest($request);
    }
}

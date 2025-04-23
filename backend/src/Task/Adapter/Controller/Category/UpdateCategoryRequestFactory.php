<?php

namespace App\Task\Adapter\Controller\Category;

use RuntimeException;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class UpdateCategoryRequestFactory
{
    public function __construct(private RequestStack $requestStack) {}

    public function getRequest(): UpdateCategoryRequest
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {throw new RuntimeException("Can`t get request for CreateProductRequest.");}
        return new UpdateCategoryRequest($request);
    }
}

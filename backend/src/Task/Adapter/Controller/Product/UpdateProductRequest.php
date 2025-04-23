<?php

namespace App\Task\Adapter\Controller\Product;

use Symfony\Component\HttpFoundation\Request;

class UpdateProductRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getId(): string
    {
        return $this->request->get('id');
    }

    public function getTitle(): string
    {
        return $this->request->get('title');
    }

    public function getAmount(): string
    {
        return $this->request->get('amount');
    }
}

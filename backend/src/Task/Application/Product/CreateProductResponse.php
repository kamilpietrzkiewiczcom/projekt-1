<?php

namespace App\Task\Application\Product;

readonly class CreateProductResponse
{
    public function __construct(private bool $status) {}

    public function getStatus(): bool
    {
        return $this->status;
    }
}

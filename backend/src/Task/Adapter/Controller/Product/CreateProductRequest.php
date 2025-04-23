<?php

namespace App\Task\Adapter\Controller\Product;

use Symfony\Component\HttpFoundation\Request;

class CreateProductRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getTitle(): string
    {
        return $this->request->get('title') ?? "";
    }

    public function getAmount(): ?float
    {
        return $this->request->get('amount');
    }

    public function getCategories(): array
    {
        $categories = $this->request->get('categories');
        preg_match_all("/[a-z0-9\-]+/", $categories, $found);
        return $found[0];
    }

    public function isValid(): bool
    {
        if ($this->getTitle() === "") {return false;}
        if ($this->getAmount() === null || $this->getAmount() <= 0) {return false;}
        if (count($this->getCategories()) === 0) {return false;}
        return true;
    }

    public function getValidationErrors(): array
    {
        $errors = [];
        if ($this->getTitle() === "") {$errors[] = "missing or empty product title";}
        if ($this->getAmount() === null || $this->getAmount() <= 0) {
            $errors[] = "missing or less than /equal to zero product price";
        }
        if (count($this->getCategories()) === 0) {
            $errors[] = "missing categories";
        }

        return $errors;
    }

}

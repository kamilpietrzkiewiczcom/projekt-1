<?php

namespace App\Task\Adapter\Controller\Category;

use Symfony\Component\HttpFoundation\Request;

class UpdateCategoryRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getId(): string
    {
        return $this->request->get('id') ?? "";
    }

    public function getCode(): string
    {
        return $this->request->get('code') ?? "";
    }

    public function isValid(): bool
    {
        if ($this->getId() === "") {return false;}
        if ($this->getCode() === "" || mb_strlen($this->getCode()) > 10) {return false;}
        return true;
    }

    public function getValidationErrors(): array
    {
        $errors = [];
        if ($this->getId() === "") {
            $errors[] = "category id can't be empty";
        }
        if ($this->getCode() === "" || mb_strlen($this->getCode()) > 10) {
            $errors[] = "category title can't be empty and at most 10 characters long";
        }

        return $errors;
    }
}

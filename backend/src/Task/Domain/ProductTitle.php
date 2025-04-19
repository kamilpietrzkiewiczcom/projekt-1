<?php

namespace App\Task\Domain;

use App\Task\Domain\Exceptions\Product\ProductTitleEmptyException;
use App\Task\Domain\Exceptions\Product\ProductTitleTooLongException;

class ProductTitle
{
    public const MAX_LENGTH = 1024;
    private string $title;

    public function __construct(string $title)
    {
        $this->assertNotEmpty($title);
        $this->assertHasValidLength($title);
        $this->titleEquals($title);
    }

    private function assertNotEmpty(string $title): void
    {
        if (mb_strlen($title) > 0) {
            return;
        }

        throw new ProductTitleEmptyException();
    }

    private function assertHasValidLength(string $title): void
    {
        if (mb_strlen($title) <= self::MAX_LENGTH) {
            return;
        }

        throw new ProductTitleTooLongException($title);
    }

    private function titleEquals(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}

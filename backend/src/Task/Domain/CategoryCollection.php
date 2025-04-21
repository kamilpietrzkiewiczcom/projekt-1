<?php

namespace App\Task\Domain;

use Iterator;

class CategoryCollection implements Iterator
{
    private int $index = 0;
    /**
     * @var Category[]
     */
    private array $data = [];

    public function append(Category $product): void
    {
        $this->data[] = $product;
    }

    public function current(): Category
    {
        return $this->data[$this->index];
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return array_key_exists($this->index, $this->data);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}

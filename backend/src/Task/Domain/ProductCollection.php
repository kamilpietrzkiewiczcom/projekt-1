<?php

namespace App\Task\Domain;

use Iterator;

class ProductCollection implements Iterator
{
    private int $index = 0;
    /**
     * @var Product[]
     */
    private array $data = [];

    public function append(Product $product): void
    {
        $this->data[] = $product;
    }

    public function current(): Product
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

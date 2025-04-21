<?php

namespace App\Task\Domain;

use Symfony\Component\Uid\Uuid;

interface ProductRepository
{
    public function getNextIdentifier(): Uuid;
    public function persist(Product $product): void;
    public function getPagesNumber(int $maxElements = 10): int;
    public function get(int $page, int $maxElements = 10): ProductCollection;
}

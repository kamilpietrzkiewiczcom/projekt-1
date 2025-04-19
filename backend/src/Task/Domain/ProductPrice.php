<?php

namespace App\Task\Domain;

use App\Task\Domain\Exceptions\Price\PriceNotMoreThanZeroException;

class ProductPrice
{
    private float $price;

    public function __construct(float $price)
    {
        $this->assertValidPrice($price);
        $this->priceEquals($price);
    }

    private function assertValidPrice(float $price): void
    {
        if ($price > 0) {
            return;
        }

        throw new PriceNotMoreThanZeroException($price);
    }

    private function priceEquals(float $price): void
    {
        $this->price = $price;
    }

    public function get(): float
    {
        return $this->price;
    }
}

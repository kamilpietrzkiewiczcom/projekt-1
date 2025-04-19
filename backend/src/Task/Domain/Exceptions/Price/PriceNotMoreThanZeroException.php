<?php

namespace App\Task\Domain\Exceptions\Price;

use InvalidArgumentException;
use Throwable;

class PriceNotMoreThanZeroException extends InvalidArgumentException
{
    public function __construct(float $price, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (mb_strlen($message) > 0) {$message .= " - ";}
        $message .= "Price for product `$price` is not greater than zero";
        parent::__construct($message, $code, $previous);
    }
}

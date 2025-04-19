<?php

namespace App\Task\Domain\Exceptions\Product;

use InvalidArgumentException;
use Throwable;

class ProductTitleEmptyException extends InvalidArgumentException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (mb_strlen($message) > 0) {$message .= " - ";}
        $message .= "Product title is empty";
        parent::__construct($message, $code, $previous);
    }
}

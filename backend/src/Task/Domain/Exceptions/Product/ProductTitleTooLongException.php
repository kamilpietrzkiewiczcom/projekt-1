<?php

namespace App\Task\Domain\Exceptions\Product;

use App\Task\Domain\ProductTitle;
use InvalidArgumentException;
use Throwable;

class ProductTitleTooLongException extends InvalidArgumentException
{
    public function __construct(string $productTitle, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if (mb_strlen($message) > 0) {$message .= " - ";}
        $message .= "Product title `$productTitle` is too long. Max allowed length is " . ProductTitle::MAX_LENGTH;
        parent::__construct($message, $code, $previous);
    }
}

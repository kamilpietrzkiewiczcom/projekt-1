<?php

namespace App\Task\Domain\Exceptions\Product;

use App\Task\Domain\ProductTitle;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;
use Throwable;

class ProductDoesNotHaveCategoryException extends InvalidArgumentException
{
    public function __construct(
        Uuid $id,
        ProductTitle $title,
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        if (mb_strlen($message) > 0) {$message .= " - ";}
        $message .= "Product `$id`, `$title` has no category attached";
        parent::__construct($message, $code, $previous);
    }
}

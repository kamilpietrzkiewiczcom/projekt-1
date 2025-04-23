<?php

namespace App\Task\Domain\Exceptions\Category;

use RuntimeException;
use Throwable;

class CategoryDoesNotExistException extends RuntimeException
{
    public function __construct(string $categoryId, $message = "", $code = 0, Throwable $previous = null)
    {
        if (mb_strlen($message) > 0) {$message .= " - ";}
        $message .= "Category `$categoryId` does not exist";
        parent::__construct($message, $code, $previous);
    }
}

<?php

namespace App\Task\Domain\Exceptions\Category;

use App\Task\Domain\CategoryCode;
use InvalidArgumentException;
use Throwable;

class CategoryCodeLengthInvalidException extends InvalidArgumentException
{
    public function __construct(string $categoryCode, $message = "", $code = 0, Throwable $previous = null)
    {
        if (mb_strlen($message) > 0) {$message .= " - ";}
        $message .= "Category code `$categoryCode` length invalid. Valid length is " .
            CategoryCode::MAX_LENGTH .
            "characters";
        parent::__construct($message, $code, $previous);
    }
}

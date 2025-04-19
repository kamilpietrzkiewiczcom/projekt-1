<?php

namespace App\Task\Domain;

use App\Task\Domain\Exceptions\Category\CategoryCodeLengthInvalidException;

class CategoryCode
{
    public const MAX_LENGTH = 10;
    private string $code;

    public function __construct(string $code)
    {
        $this->assertValidLength($code);
        $this->codeEquals($code);
    }

    private function assertValidLength(string $code): void
    {
        if (mb_strlen($code) <= self::MAX_LENGTH) {
            return;
        }

        throw new CategoryCodeLengthInvalidException($code);
    }

    private function codeEquals(string $code): void
    {
        $this->code = $code;
    }

    public function get(): string
    {
        return $this->code;
    }
}

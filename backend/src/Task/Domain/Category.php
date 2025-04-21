<?php

namespace App\Task\Domain;

use DateTime;
use Symfony\Component\Uid\Uuid;

final class Category
{
    private Uuid $id;
    private CategoryCode $code;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    /**
     * @param Uuid $id
     * @param CategoryCode $code
     */
    public function __construct(Uuid $id, CategoryCode $code)
    {
        $this->id = $id;
        $this->code = $code;
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getCode(): string
    {
        return $this->code->get();
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }

    final public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
    }

    final public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}

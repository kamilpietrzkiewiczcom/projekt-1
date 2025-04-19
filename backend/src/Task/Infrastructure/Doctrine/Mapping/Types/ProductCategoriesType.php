<?php

declare(strict_types=1);

namespace App\Task\Domain\Doctrine\Mapping\Types;

use App\Task\Infrastructure\Doctrine\Mapping\Types\Email;
use App\Task\Infrastructure\Doctrine\Mapping\Types\EmailIsNotValid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\SimpleArrayType;
use Iterator;
use Symfony\Component\Uid\Uuid;

final class ProductCategoriesType extends SimpleArrayType implements Iterator
{
    public const NAME = 'ProductCategoriesType';
    private int $index = 0;
    private ArrayCollection $collection;

    public function append(Uuid $categoryId): self
    {
        $this->collection->add($categoryId);
        return $this;
    }

    public function current(): Uuid
    {
        return $this->collection->get($this->index);
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return $this->collection->offsetExists($this->index);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function getIterator(): Iterator
    {
        return $this;
    }

    /** @throws ConversionException */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof ArrayCollection) {
            return parent::convertToDatabaseValue($value->toArray(), $platform);
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            $this->getName(),
            ['null', ProductCategoriesType::class],
        );
    }

    /** @throws ConversionException */
    public function convertToPHPValue($value, AbstractPlatform $platform): ProductCategoriesType|null
    {
        /** @var string|null $value */
        $value = parent::convertToPHPValue($value, $platform);

        if ($value === null) {
            return null;
        }

        var_dump($value);
        die;

        //return new ProductCategoriesType();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}

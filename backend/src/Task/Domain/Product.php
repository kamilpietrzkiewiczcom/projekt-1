<?php

namespace App\Task\Domain;

use App\Task\Domain\Exceptions\Product\ProductDoesNotHaveCategoryException;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Iterator;
use Symfony\Component\Uid\Uuid;

class Product
{
    private Uuid $id;
    private ProductTitle $title;
    private ProductPrice $price;
    /**
     * @var ArrayCollection|Category[]
     */
    private ArrayCollection $category;

    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(Uuid $id, ProductTitle $title, ProductPrice $price)
    {
        $this->initCategory();
        $this->setId($id);
        $this->setTitle($title);
        $this->setPrice($price);
    }

    private function initCategory(): void
    {
        $this->category = new ArrayCollection();
    }

    private function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    private function setTitle(ProductTitle $title): void
    {
        $this->title = $title;
    }

    private function setPrice(ProductPrice $price): void
    {
        $this->price = $price;
    }

    private function addCategory(Category $category): void
    {
        $this->category->add($category);
    }

    /**
     * @throws Exception
     */
    private function removeCategory(Category $category): void
    {
        $iterator = $this->category->getIterator();
        while ($iterator->valid()) {
            /**
             * @var Category $current
             */
            $current = $iterator->current();
            if ($current->getId() === $category->getId()) {
                $this->category->remove($iterator->key());
            }
            $iterator->next();
        }
    }

    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    private function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getTitle(): string
    {
        return $this->title->getTitle();
    }

    public function getPrice(): float
    {
        return $this->price->get();
    }

    /**
     * @throws Exception
     */
    public function getCategory(): Iterator
    {
        return $this->category->getIterator();
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }

    /**
     * @throws Exception
     */
    final public function onPrePersist(): void
    {
        $iterator = $this->category->getIterator();
        if (!$iterator->valid()) {throw new ProductDoesNotHaveCategoryException(
            $this->id,
            $this->title
        );}

        $this->createdAt = new DateTime();
    }

    /**
     * @throws Exception
     */
    final public function onPreUpdate(): void
    {
        $iterator = $this->category->getIterator();
        if (!$iterator->valid()) {throw new ProductDoesNotHaveCategoryException(
            $this->id,
            $this->title
        );}

        $this->updatedAt = new DateTime();
    }
}

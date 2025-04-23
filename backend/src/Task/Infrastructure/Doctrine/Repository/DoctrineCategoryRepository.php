<?php

namespace App\Task\Infrastructure\Doctrine\Repository;

use App\Task\Domain\Category;
use App\Task\Domain\CategoryCollection;
use App\Task\Domain\CategoryRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class DoctrineCategoryRepository extends ServiceEntityRepository implements CategoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getNextIdentifier(): Uuid
    {
        return Uuid::v4(); // here logic should be more complex - add check if product by that id exists
    }

    public function persist(Category $product): void
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }

    /**
     * here we could return iterator to iterate over database entries - for simplicity I return here collection
     */
    public function getAll(): CategoryCollection
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('c')
            ->from(Category::class, 'c')
            ->getQuery();
        $results = $query->getResult();
        $collection = new CategoryCollection();
        foreach ($results as $entity) {
            $collection->append($entity);
        }
        return $collection;
    }

    /**
     * @throws ORMException
     */
    public function removeCategory(Uuid $categoryId): void
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference(Category::class, ['id' => $categoryId]);
        $em->remove($proxy);
        $em->flush();
    }

    public function getCategoryById(Uuid $id): Category
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('c')
            ->from(Category::class, 'c')
            ->where('c.id = :id')
            ->setParameter(":id", $id->toBinary())
            ->getQuery();
        return $query->getSingleResult();
    }
}

<?php

namespace App\Task\Infrastructure\Doctrine\Repository;

use App\Task\Domain\Product;
use App\Task\Domain\ProductCollection;
use App\Task\Domain\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getNextIdentifier(): Uuid
    {
        return Uuid::v4(); // here logic should be more complex - add check if product by that id exists
    }

    public function persist(Product $product): void
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }

    public function getPagesNumber(int $maxElements = 10): int
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('count(p.id)')
            ->from(Product::class, 'p')
            ->getQuery();
        return $query->getSingleScalarResult();
    }

    /**
     * here we could return iterator to iterate over database entries - for simplicity I return here collection
     * by page
     */
    public function get(int $page, int $maxElements = 10): ProductCollection
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('p')
            ->from(Product::class, 'p')
            ->setFirstResult($page * $maxElements)
            ->setMaxResults($maxElements)
            ->getQuery();
        $results = $query->getResult();
        $collection = new ProductCollection();
        foreach ($results as $entity) {
            $collection->append($entity);
        }
        return $collection;
    }
}

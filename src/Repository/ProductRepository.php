<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<Product>
 */
final class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function exists(int|string $value, string $field): bool
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.'.$field.' = :value')
            ->setParameter('value', $value);

        return $queryBuilder->getQuery()
                ->getOneOrNullResult() !== null;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function unique(string $value, string $field, ?int $id = null): bool
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('w.' . $field . ' = :value')
            ->setParameter('value', $value);
        if ($id !== null) {
            $this->whereUuidNot($queryBuilder, $id);
        }

        return $queryBuilder->getQuery()
                ->getOneOrNullResult() === null;
    }

    /**
     * @param QueryBuilder $query
     * @param int $id
     * @return void
     */
    protected function whereUuidNot(QueryBuilder $query, int $id): void
    {
        $query->andWhere('p.id != :id')
            ->setParameter('id', $id);
    }

    public function save(Product $product): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($product);
        $entityManager->flush();
    }

    public function persist(Product $product): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($product);
    }

    public function remove(Product $product): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($product);
        $entityManager->flush();
    }

    public function flush(): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->flush();
    }

}

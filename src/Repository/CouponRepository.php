<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coupon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coupon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coupon[]    findAll()
 * @method Coupon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<Coupon>
 */
final class CouponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function exists(int|string $value, string $field): bool
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.'.$field.' = :value')
            ->setParameter('value', $value);

        return $queryBuilder->getQuery()
                ->getOneOrNullResult() !== null;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function unique(string $value, string $field, ?int $id = null): bool
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.' . $field . ' = :value')
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
        $query->andWhere('c.id != :id')
            ->setParameter('id', $id);
    }

    public function save(Coupon $coupon): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($coupon);
        $entityManager->flush();
    }

    public function persist(Coupon $coupon): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($coupon);
    }

    public function remove(Coupon $coupon): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($coupon);
        $entityManager->flush();
    }

    public function flush(): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->flush();
    }

}

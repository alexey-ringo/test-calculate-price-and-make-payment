<?php
declare(strict_types=1);

namespace App\Repository;

use App\Dto\GetDto;
use App\Entity\CounterpartyWalletSettings;
use App\Entity\Product;
use App\Entity\Wallet;
use App\Entity\WalletCounterparty;
use App\Exception\NotFoundGrpcException;
use App\Helper\GrpcErrorHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
    public function exists(string $value, string $field): bool
    {
        $queryBuilder = $this->createQueryBuilder('w')
            ->where('w.'.$field.' = :value')
            ->setParameter('value', $value);

        return $queryBuilder->getQuery()
                ->getOneOrNullResult() !== null;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function unique(string $value, string $field, ?string $hashId = null): bool
    {
        $queryBuilder = $this->createQueryBuilder('w')
            ->where('w.' . $field . ' = :value')
            ->setParameter('value', $value);
        if ($hashId !== null) {
            $this->whereUuidNot($queryBuilder, $hashId);
        }

        return $queryBuilder->getQuery()
                ->getOneOrNullResult() === null;
    }






    /**
     * @param  QueryBuilder  $query
     * @param  string  $hashId
     * @return void
     */
    protected function whereUuidNot(QueryBuilder $query, string $hashId): void
    {
        $query->andWhere('w.hashId != :hashId')
            ->setParameter('hashId', $hashId);
    }





    public function save(Wallet $wallet): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($wallet);
        $entityManager->flush();
    }

    public function persist(Wallet $wallet): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($wallet);
    }

    public function remove(Wallet $wallet): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($wallet);
        $entityManager->flush();
    }

    public function removeWithoutFlush(Wallet $wallet): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->remove($wallet);
    }

    public function flush(): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->flush();
    }

    /**
     * @param  GetDto  $dto
     * @return Paginator<Wallet>
     */
    public function getPaginator(GetDto $dto): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('w');
        if (count($dto->getHashIds()) > 0) {
            $queryBuilder
                ->where('w.hashId in (:hashIds)')
                ->setParameter('hashIds', $dto->getHashIds());
        }
        $listDto = $dto->getList();
        if ($listDto !== null) {
            $limit = $listDto->getLimit()?->hasData() ?? false;
            $offset = $listDto->getOffset()?->hasData() ?? false;
            if ($limit === true || $offset === true) {
                $queryBuilder
                    ->setFirstResult($listDto->getOffset()?->getData() ?? 0)
                    ->setMaxResults($listDto->getLimit()?->getData() ?? 10);
            }
            $identifier = $listDto->getIdentifier()?->hasData() ?? false;
            if ($identifier === true) {
                $queryBuilder
                    ->andWhere('w.identifier = :identifier')
                    ->setParameter('identifier', $listDto->getIdentifier()?->getData() ?? '');
            }
            if ($listDto->getIsActive()?->hasData()) {
                $isActive = $listDto->getIsActive() !== null && $listDto->getIsActive()->getData();
                if ($isActive === true) {
                    $queryBuilder
                        ->join(WalletCounterparty::class, 'wc', Join::WITH, 'wc.wallet = w.hashId')
                        ->join(CounterpartyWalletSettings::class, 'cws', Join::WITH, 'cws.walletCounterparty = wc.uuid')
                        ->andWhere('cws.isActive = :isActive')
                        ->setParameter('isActive', true);
                } else {
                    $walletHashIds = $this->getWalletHashIdsWithAllIsActiveEqualTrue();
                    if (count($walletHashIds) === 0) {
                        $walletHashIds[] = '1';
                    }
                    $queryBuilder
                        ->andWhere($queryBuilder->expr()->notIn('w.hashId', ':walletHashIds'))
                        ->setParameter('walletHashIds', $walletHashIds);
                }
            }
            $removed = $listDto->getRemoved()?->hasData() ?? false;
            if ($removed === true && $listDto->getRemoved()?->getData() === true) {
                $queryBuilder
                    ->andWhere('w.removedAt is not null');
            }
            if ($removed === true && $listDto->getRemoved()?->getData() === false) {
                $queryBuilder
                    ->andWhere('w.removedAt is null');
            }
            $walletTypeCode = $listDto->getWalletTypeCode()?->hasData() ?? false;
            if ($walletTypeCode === true) {
                $queryBuilder
                    ->andWhere('w.walletTypeCode = :walletTypeCode')
                    ->setParameter('walletTypeCode', $listDto->getWalletTypeCode()?->getData() ?? '');
            }
            $username = $listDto->getUsername()?->hasData() ?? false;
            if ($username === true) {
                $queryBuilder
                    ->andWhere('w.username = :username')
                    ->setParameter('username', $listDto->getUsername()?->getData() ?? '');
            }
            $emailUsername = $listDto->getEmailUsername()?->hasData() ?? false;
            if ($emailUsername === true) {
                $queryBuilder
                    ->andWhere('w.emailUsername = :emailUsername')
                    ->setParameter('emailUsername', $listDto->getEmailUsername()?->getData() ?? '');
            }
            $hashId = $listDto->getHashId()?->hasData() ?? false;
            if ($hashId === true) {
                $queryBuilder
                    ->andWhere('w.hashId = :hashId')
                    ->setParameter('hashId', $listDto->getHashId()?->getData() ?? '');
            }
            $hasDisplayIdentifier = $listDto->getDisplayIdentifier()?->hasData() ?? false;
            if ($hasDisplayIdentifier === true) {
                $displayIdentifier = $listDto->getDisplayIdentifier()?->getData() ?? '';
                $displayIdentifier = empty($displayIdentifier) ? '' : '%' . $displayIdentifier . '%';
                $queryBuilder
                    ->andWhere('w.displayIdentifier LIKE :displayIdentifier')
                    ->setParameter('displayIdentifier', $displayIdentifier);
            }
        }

        return new Paginator($queryBuilder->getQuery(), false);
    }



}

<?php

namespace App\Repository;

use App\Entity\AccountingGroup1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountingGroup1>
 *
 * @method AccountingGroup1|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountingGroup1|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountingGroup1[]    findAll()
 * @method AccountingGroup1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountingGroup1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountingGroup1::class);
    }

    public function add(AccountingGroup1 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccountingGroup1 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AccountingGroup1[] Returns an array of AccountingGroup1 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AccountingGroup1
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

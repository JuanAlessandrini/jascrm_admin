<?php

namespace App\Repository;

use App\Entity\AccountingGroup2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountingGroup2>
 *
 * @method AccountingGroup2|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountingGroup2|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountingGroup2[]    findAll()
 * @method AccountingGroup2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountingGroup2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountingGroup2::class);
    }

    public function add(AccountingGroup2 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccountingGroup2 $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AccountingGroup2[] Returns an array of AccountingGroup2 objects
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

//    public function findOneBySomeField($value): ?AccountingGroup2
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

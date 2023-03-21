<?php

namespace App\Repository;

use App\Entity\CuentaAuxiliar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CuentaAuxiliar>
 *
 * @method CuentaAuxiliar|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuentaAuxiliar|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuentaAuxiliar[]    findAll()
 * @method CuentaAuxiliar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuentaAuxiliarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuentaAuxiliar::class);
    }

    public function add(CuentaAuxiliar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CuentaAuxiliar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CuentaAuxiliar[] Returns an array of CuentaAuxiliar objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CuentaAuxiliar
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

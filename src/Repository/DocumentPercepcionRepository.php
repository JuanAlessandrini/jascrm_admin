<?php

namespace App\Repository;

use App\Entity\DocumentPercepcion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocumentPercepcion>
 *
 * @method DocumentPercepcion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentPercepcion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentPercepcion[]    findAll()
 * @method DocumentPercepcion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentPercepcionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentPercepcion::class);
    }

    public function add(DocumentPercepcion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DocumentPercepcion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DocumentPercepcion[] Returns an array of DocumentPercepcion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DocumentPercepcion
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

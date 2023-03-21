<?php

namespace App\Repository;

use App\Entity\EntidadTypeDoc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntidadTypeDoc>
 *
 * @method EntidadTypeDoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntidadTypeDoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntidadTypeDoc[]    findAll()
 * @method EntidadTypeDoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntidadTypeDocRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntidadTypeDoc::class);
    }

    public function add(EntidadTypeDoc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EntidadTypeDoc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EntidadTypeDoc[] Returns an array of EntidadTypeDoc objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EntidadTypeDoc
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

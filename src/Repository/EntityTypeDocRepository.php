<?php

namespace App\Repository;

use App\Entity\EntityTypeDoc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntityTypeDoc>
 *
 * @method EntityTypeDoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityTypeDoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityTypeDoc[]    findAll()
 * @method EntityTypeDoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityTypeDocRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityTypeDoc::class);
    }

    public function add(EntityTypeDoc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EntityTypeDoc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EntityTypeDoc[] Returns an array of EntityTypeDoc objects
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

//    public function findOneBySomeField($value): ?EntityTypeDoc
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

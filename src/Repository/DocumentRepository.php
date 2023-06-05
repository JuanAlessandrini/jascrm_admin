<?php

namespace App\Repository;

use App\Entity\Document;
use App\Entity\Reporte;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Document>
 *
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function add(Document $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Document $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

           
    public function aplicaFiltros($request, $customer, $typeEnt){
        $query = $this->createQueryBuilder('d')
        ->join('d.vendor', 'v')
        ->join('d.grano', 'g')
        ->andWhere('d.customer = :customer')
        ->andWhere('d.tipo = :tipo')
        ->setParameter('customer', $customer)
        ->setParameter('tipo', $typeEnt)
        ;

        if($request->get('fromdate')){
            $query->andWhere('d.created_at >= :fechafrom')
            ->setParameter('fechafrom', new \DateTime($request->get('fromdate')));
        }

        

        if($request->get('todate')){
            $query->andWhere('d.created_at <= :todate')
            ->setParameter('todate', new \DateTime($request->get('todate')));
        }

        if($request->get('codigo')){
            $query->andWhere('d.codigo = :codigo')
            ->setParameter('codigo', $request->get('codigo'));
        }
        if($request->get('nrocmpbte')){
            $query->andWhere('d.numero = :nrocmpbte')
            ->setParameter('nrocmpbte', $request->get('nrocmpbte'));
        }
        if($request->get('proveedor')){
            $query
                ->andWhere('v.name LIKE :vendor')
                ->setParameter('vendor', '%'.$request->get('proveedor').'%');
        }
        if($request->get('campana')){
            $query
                ->andWhere('d.campania = :campana')
                ->setParameter('campana', $request->get('campana'));
        }

        if($request->get('centro_costo')){
            $query->andWhere('d.centro_costo >= :centrocosto')
            ->setParameter('centrocosto', $request->get('centro_costo'));
        }

        if($request->get('grano')){
            $query
                ->andWhere('g.id = :grano')
                ->setParameter('grano', $request->get('grano'));
        }
        
        

        $result = $query->orderBy('d.id', 'ASC')
        ->setMaxResults(100)
        ->getQuery()
        ->getResult();

        return $result;
    }

    public function getBaseReport($request, Reporte $report, Customer $customer){

        $query = $this->createQueryBuilder('d')
        ->join('d.vendor', 'v')
        ->join('d.grano', 'g')
        ->andWhere('d.customer = :customer')
        ->andWhere('d.tipo IN (:tipos)')
        ->setParameter('customer', $customer)
        ->setParameter('tipos', $report->getTipos())
        ;

        if($request->get('fromdate')){
            $query->andWhere('d.created_at >= :fechafrom')
            ->setParameter('fechafrom', new \DateTime($request->get('fromdate')));
        }

        if($request->get('todate')){
            $query->andWhere('d.created_at <= :todate')
            ->setParameter('todate', new \DateTime($request->get('todate')));
        }

        if($request->get('codigo')){
            $query->andWhere('d.codigo = :codigo')
            ->setParameter('codigo', $request->get('codigo'));
        }
        if($request->get('nrocmpbte')){
            $query->andWhere('d.numero = :nrocmpbte')
            ->setParameter('nrocmpbte', $request->get('nrocmpbte'));
        }
        if($request->get('proveedor')){
            $query
                ->andWhere('v.name LIKE :vendor')
                ->setParameter('vendor', '%'.$request->get('proveedor').'%');
        }
        if($request->get('campana')){
            $query
                ->andWhere('d.campania = :campana')
                ->setParameter('campana', $request->get('campana'));
        }

        if($request->get('grano')){
            $query
                ->andWhere('g.id = :grano')
                ->setParameter('grano', $request->get('grano'));
        }
        
        

        $result = $query->orderBy('d.id', 'ASC')
        ->setMaxResults(100)
        ->getQuery()
        ->getResult();

        return $result;
    }

//    /**
//     * @return Document[] Returns an array of Document objects
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

//    public function findOneBySomeField($value): ?Document
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

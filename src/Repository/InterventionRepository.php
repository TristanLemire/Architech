<?php

namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    public function futurEvent(int $id_building): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i.id AS id_intervention, a.id, a.type, i.datetime, e.name as company, c.name, c.floor, c.zone, a.status, i.comment')
            ->innerJoin('App\Entity\Incident', 'a',   Expr\Join::WITH,  'a.intervention = i.id')
            ->innerJoin('App\Entity\Classroom', 'c',   Expr\Join::WITH,  'a.classroom = c.id')
            ->innerJoin('App\Entity\Building', 'b',   Expr\Join::WITH,  'c.building = b.id')
            ->innerJoin('App\Entity\Company', 'e',   Expr\Join::WITH,  'i.company = e.id')
            ->where('a.status = :assign')
            ->setParameter('assign', 'assign')
            ->andWhere('b.id = :id_building')
            ->setParameter('id_building', $id_building)
            ->andWhere('MONTH(i.datetime) = MONTH(CURRENT_DATE())')
            ->andWhere('YEAR(i.datetime) = YEAR(CURRENT_DATE())')
            ->orderBy('i.datetime');;

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function allFuturEvent(int $id_building): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i.id AS id_intervention, a.id, a.type, i.datetime, e.name as company, c.name, c.floor, c.zone, a.status, i.comment')
            ->innerJoin('App\Entity\Incident', 'a',   Expr\Join::WITH,  'a.intervention = i.id')
            ->innerJoin('App\Entity\Classroom', 'c',   Expr\Join::WITH,  'a.classroom = c.id')
            ->innerJoin('App\Entity\Building', 'b',   Expr\Join::WITH,  'c.building = b.id')
            ->innerJoin('App\Entity\Company', 'e',   Expr\Join::WITH,  'i.company = e.id')
            ->where('a.status = :assign')
            ->setParameter('assign', 'assign')
            ->andWhere('b.id = :id_building')
            ->setParameter('id_building', $id_building)
            ->andWhere('MONTH(i.datetime) >= MONTH(CURRENT_DATE())')
            ->andWhere('YEAR(i.datetime) >= YEAR(CURRENT_DATE())')
            ->orderBy('i.datetime');;

        $query = $qb->getQuery();
        return $query->getResult();
    }

    // /**
    //  * @return Intervention[] Returns an array of Intervention objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intervention
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

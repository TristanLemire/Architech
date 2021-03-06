<?php

namespace App\Repository;

use App\Entity\Incident;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @method Incident|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incident|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incident[]    findAll()
 * @method Incident[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Incident::class);
    }

    public function findIncidentByIdBuilding(int $id_building, $current_date = false): array
    {
        $where_query = ($current_date) ? 'MONTH(i.date) = MONTH(CURRENT_DATE())' : 'MONTH(i.date) = MONTH(CURRENT_DATE()) - 1';
        $results = $this->createQueryBuilder('i')
            ->select('
                i.id,
                i.title,
                i.type,
                i.date,
                i.status,
                c.name,
                c.floor,
                c.zone
                ')
            ->innerJoin('App\Entity\Classroom', 'c',   Expr\Join::WITH,  'i.classroom = c.id')
            ->innerJoin('App\Entity\Building', 'b',   Expr\Join::WITH,  'c.building = b.id')
            ->where($where_query)
            ->andWhere('b.id = :id_building')
            ->setParameter('id_building', $id_building)
            ->getQuery()
            ->getResult();

        return $results;
    }

    public function annualEvolution(int $id_building): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i')
            ->innerJoin('App\Entity\Classroom', 'c',   Expr\Join::WITH,  'i.classroom = c.id')
            ->innerJoin('App\Entity\Building', 'b',   Expr\Join::WITH,  'c.building = b.id')
            ->where('i.date >= DATEADD(DATEADD(LAST_DAY(CURRENT_DATE()),1,\'DAY\'),-12,\'MONTH\')')
            ->andWhere('i.date <= LAST_DAY(CURRENT_DATE()) ')
            ->andWhere('b.id = :id_building')
            ->setParameter('id_building', $id_building)
            ->orderBy('i.date');

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function agenda(int $id_building): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb->select('i.id,i.title,i.date,i.type,i.status,c.id as classroom_id,c.name,c.floor,c.zone')
            ->innerJoin('App\Entity\Classroom', 'c',   Expr\Join::WITH,  'i.classroom = c.id')
            ->innerJoin('App\Entity\Building', 'b',   Expr\Join::WITH,  'c.building = b.id')
            ->where('i.status = :status')
            ->setParameter('status', "in_progress")
            ->andWhere('b.id = :id_building')
            ->setParameter('id_building', $id_building);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    // /**
    //  * @return Incident[] Returns an array of Incident objects
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
    public function findOneBySomeField($value): ?Incident
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

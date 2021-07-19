<?php

namespace App\Repository;

use App\Entity\Building;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @method Building|null find($id, $lockMode = null, $lockVersion = null)
 * @method Building|null findOneBy(array $criteria, array $orderBy = null)
 * @method Building[]    findAll()
 * @method Building[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Building::class);
    }

    public function findInfoByIdBuilding(int $id_building): array
    {
        $results = $this->createQueryBuilder('b')
          ->select('
            b.name as name_building, 
            b.phone as phone_building, 
            b.city, 
            b.address, 
            b.zipcode,
            b.mail,
            m.last_name, 
            m.first_name, 
            m.phone AS phone_manager, 
            m.gender,
            m.mail AS manager_mail
          ')
          ->addSelect('(SELECT COUNT(c.id)
           FROM App\Entity\Classroom AS c
           WHERE c.building = 1) AS number_rooms
          ')
          ->addSelect('(SELECT COUNT(s.id)
           FROM App\Entity\Sensor AS s
           WHERE s.classroom = 1) AS number_sensor
          ')
          ->leftJoin('App\Entity\Manager', 'm',   Expr\Join::WITH,  'b.manager = m.id')
          ->where('b.id = :id_building')
          ->setParameter('id_building', $id_building)
          ->getQuery()
          ->getResult();


        return $results;
    }

    // /**
    //  * @return Building[] Returns an array of Building objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Building
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

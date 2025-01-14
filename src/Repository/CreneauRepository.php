<?php

namespace App\Repository;

use App\Entity\Creneau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
/**
 * @extends ServiceEntityRepository<Creneau>
 */
class CreneauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creneau::class);
    }

    //    /**
    //     * @return Creneau[] Returns an array of Creneau objects
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

    //    public function findOneBySomeField($value): ?Creneau
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getCreneauxOverview(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select(
                'DATE(c.date) as date', // Use the DATE function
                'SUM(CASE WHEN c.dispo = true THEN 1 ELSE 0 END) as available',
                'SUM(CASE WHEN c.dispo = false THEN 1 ELSE 0 END) as reserved'
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC');

        $results = $qb->getQuery()->getResult();

        $overview = [];
        foreach ($results as $result) {
            $overview[$result['date']] = [
                'available' => (int) $result['available'],
                'reserved' => (int) $result['reserved'],
            ];
        }

        return $overview;
    }
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.users', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }
    
    public function user():User{
        return $this->createQueryBuilder('c')
            ->join('c.users', 'u')
            ->getQuery()
            ->getResult();
    }


}
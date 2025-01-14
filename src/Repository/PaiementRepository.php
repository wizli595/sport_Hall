<?php

namespace App\Repository;

use App\Entity\Paiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<Paiement>
 */
class PaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paiement::class);
    }

    //    /**
    //     * @return Paiement[] Returns an array of Paiement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Paiement
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getMonthlyPayments(): array
    {
        // Access the Doctrine DBAL connection
        $conn = $this->getEntityManager()->getConnection();
    
        // Use raw SQL to calculate payments grouped by month
        $sql = "
            SELECT MONTH(pay_date) AS month, SUM(montant) AS total
            FROM paiement
            GROUP BY month
            ORDER BY month ASC
        ";
    
        // Execute the query
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
    
        // Process results
        $payments = [];
        foreach ($resultSet->fetchAllAssociative() as $result) {
            $monthName = date("F", mktime(0, 0, 0, $result['month'], 1));
            $payments[$monthName] = $result['total'];
        }
    
        return $payments;
    }
    public function getTotalPayments(): float
    {
        return (float) $this->createQueryBuilder('p')
            ->select('SUM(p.montant)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    
}
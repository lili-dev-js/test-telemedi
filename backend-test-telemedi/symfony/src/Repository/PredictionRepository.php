<?php

namespace App\Repository;

use App\Entity\Prediction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prediction>
 *
 * @method Prediction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prediction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prediction[]    findAll()
 * @method Prediction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PredictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prediction::class);
    }

    // Przykładowa metoda do wyszukiwania prognoz po dacie i dziale
    public function findByDateAndDepartment(\DateTimeInterface $date, int $departmentId): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.department', 'd')
            ->andWhere('p.date = :date')
            ->andWhere('d.id = :departmentId')
            ->setParameter('date', $date)
            ->setParameter('departmentId', $departmentId)
            ->getQuery()
            ->getResult();
    }

}

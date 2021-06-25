<?php

namespace App\Repository;

use App\Entity\Vegetable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vegetable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vegetable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vegetable[]    findAll()
 * @method Vegetable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VegetableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vegetable::class);
    }

    public function findByTermStrict(string $term)
    {
        $queryBuilder = $this->createQueryBuilder('e');

        $queryBuilder->where('e.name = :term');

        $queryBuilder->setParameter('term', $term);
        $queryBuilder->orderBy('e.id', 'ASC');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function findByTerm(string $term)
    {
        $queryBuilder = $this->createQueryBuilder('e');

        $queryBuilder->where(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.name' , ':term'),
                $queryBuilder->expr()->like('e.harvest' , ':term'),
            )
        )
        ->setParameter('term', '%'.$term.'%')
        ->orderBy('e.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Vegetable[] Returns an array of Vegetable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vegetable
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

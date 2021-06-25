<?php

namespace App\Repository;

use App\Entity\Aromatic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aromatic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aromatic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aromatic[]    findAll()
 * @method Aromatic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AromaticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aromatic::class);
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
    //  * @return Aromatic[] Returns an array of Aromatic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aromatic
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

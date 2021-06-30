<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
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
                $queryBuilder->expr()->like('e.email' , ':term'),
            )
        )
        ->setParameter('term', '%'.$term.'%')
        ->orderBy('e.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

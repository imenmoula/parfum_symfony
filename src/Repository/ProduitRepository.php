<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use src\Class\Search;
use app\Entity\Category;
use app\Entity\Parfum;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
 public function findWithSearch(Search $search)
{
    $query = $this->createQueryBuilder('p')
        ->select('c', 'p')
        ->join('p.category', 'c');

    if (!empty($search->category)) {
        $query = $query
            ->andWhere('c.id IN (:category)')
            ->setParameter('category', $search->category);
    }

    if (!empty($search->string)) {
        $query = $query
            ->andWhere('p.nom LIKE :string')
            ->setParameter('string', '%' . $search->string . '%');
    }

    return $query->getQuery()->getResult();
}
    //    /**
    //     * @return Produit[] Returns an array of Produit objects
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

    //    public function findOneBySomeField($value): ?Produit
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

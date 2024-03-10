<?php

namespace App\Repository;

use App\Entity\ProductHasNutrients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductHasNutrients>
 *
 * @method ProductHasNutrients|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductHasNutrients|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductHasNutrients[]    findAll()
 * @method ProductHasNutrients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductHasNutrientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductHasNutrients::class);
    }

//    /**
//     * @return ProductHasNutrients[] Returns an array of ProductHasNutrients objects
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

//    public function findOneBySomeField($value): ?ProductHasNutrients
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

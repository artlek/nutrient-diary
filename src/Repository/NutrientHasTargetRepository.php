<?php

namespace App\Repository;

use App\Entity\NutrientHasTarget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NutrientHasTarget>
 *
 * @method NutrientHasTarget|null find($id, $lockMode = null, $lockVersion = null)
 * @method NutrientHasTarget|null findOneBy(array $criteria, array $orderBy = null)
 * @method NutrientHasTarget[]    findAll()
 * @method NutrientHasTarget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NutrientHasTargetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NutrientHasTarget::class);
    }

    public function save(NutrientHasTarget $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NutrientHasTarget $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NutrientHasTarget[] Returns an array of NutrientHasTarget objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NutrientHasTarget
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

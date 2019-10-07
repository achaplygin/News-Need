<?php

namespace App\Repository\Form;

use App\Entity\Form\NewsForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NewsForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsForm[]    findAll()
 * @method NewsForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsForm::class);
    }

    // /**
    //  * @return NewsForm[] Returns an array of NewsForm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsForm
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

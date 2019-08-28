<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findProduct()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ="SELECT *
        FROM product
        ORDER BY RAND( )
        LIMIT 4";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // Retourne toujours un tableau de Product
        $product = $stmt->fetchAll();
        return $product;
    }

    public function findLastCreatedAt($chiffre)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.date', 'ASC')
            ->setMaxResults($chiffre)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBestProduct()
    {
        return $this->createQueryBuilder('p')
            ->where('p.heart =1')
            ->setMaxResults(4)
            ->orderBy('p.id','DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}

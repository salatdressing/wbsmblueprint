<?php

namespace App\Repository;

use App\Entity\Brands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Brands|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brands|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brands[]    findAll()
 * @method Brands[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brands::class);
    }

    public function getPage($pageNumber): array
    {
      $entityManager = $this->getEntityManager();

      $limit = 10;
      if($pageNumber < 1){
        $pageNumber = 1;
      }
      $offset = ($pageNumber - 1) * $limit;

      /*$query = $entityManager->createQuery(
          'SELECT b FROM App\Entity\Brands b LIMIT :limit OFFSET :offset '
      )->setParameter('limit', $limit)->setParameter('offset', $offset);

      */

      $qb = $entityManager->createQueryBuilder();
      $qb->add('select', 'b')
      ->add('from', 'Brands b')
      ->add('orderBy', 'u.id ASC')
      ->setFirstResult( $offset )
      ->setMaxResults( $limit );



      return $qb->getQuery()->execute();
    }
//    /**
//     * @return Brands[] Returns an array of Brands objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Brands
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

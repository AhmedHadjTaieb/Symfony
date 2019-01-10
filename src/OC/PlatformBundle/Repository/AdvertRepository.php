<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository {
  public function getAdvertWithCategories(array $categoryNames) {
    $qb = $this->createQueryBuilder('a');

    $qb->innerJoin('a.categories', 'c')
      ->addSelect('c');

    $qb->where($qb->expr()->in('c.name', $categoryNames));

    return $qb
      ->getQuery()
      ->getResult();
  }

  public function getAdverts($page, $nbrPages) {
    $qb = $this->createQueryBuilder('a')
      ->select('a')
      ->leftJoin('a.image', 'i')
      ->addSelect('i')
      ->leftJoin('a.categories', 'c')
      ->addselect('c')
      ->orderBy('a.date', 'DESC')
      ->getQuery();


    $qb->setFirstResult(($page - 1) * $nbrPages)
      ->setMaxResults($nbrPages);

    return new Paginator($qb, TRUE);
  }

  public function getAdvertsBefore(\Datetime $date) {
    return $this->createQueryBuilder('a')
      ->where('a.updateAt <= :date')
      ->orWhere('a.updateAt IS NULL AND a.date <= :date')
      ->andWhere('a.applications IS EMPTY')
      ->setParameter('date', $date)
      ->getQuery()
      ->getResult();
  }


}

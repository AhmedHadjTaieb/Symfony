<?php
/**
 * Created by PhpStorm.
 * User: ahmed.hadjtaieb
 * Date: 07/01/19
 * Time: 14:57
 */

namespace OCPlatformBundle\PurgeAdvert;

use Doctrine\ORM\EntityManager;

class OCPurgerAdvert {

  private $entityManager;

  public function __construct(EntityManager $em) {
    $this->entityManager = $em;
  }

  /**
   *
   * Purge Advert  Entity
   *
   * @param integer $days
   *
   */
  public function purge($days) {
    $dateSearched = date('Y-m-d H:i:m', strtotime("-$days days"));
    $qb = $this->entityManager->createQueryBuilder();
    $qb->delete('OCPlatformBundle:Advert', 'a')
      ->where('a.date <= :dateSearched AND a.nbApplications = 0')
      ->setParameter('dateSearched', $dateSearched)
      ->getQuery()
      ->execute();
  }
}
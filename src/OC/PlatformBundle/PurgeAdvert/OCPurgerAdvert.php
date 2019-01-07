<?php
/**
 * Created by PhpStorm.
 * User: ahmed.hadjtaieb
 * Date: 07/01/19
 * Time: 14:57
 */

namespace OCPlatformBundle\PurgeAdvert;

use Doctrine\ORM\EntityManagerInterface;

class OCPurgerAdvert {

  private $em;

  public function __construct(EntityManagerInterface $em) {
    $this->em = $em;
  }

  /**
   *
   * Purge Advert  Entity
   *
   * @param integer $days
   *
   */
  public function purge($days) {
    $advertRepository = $this->em->getRepository('OCPlatformBundle:Advert');
    $advertSkillRepository = $this->em->getRepository('OCPlatformBundle:AdvertSkill');
    $date = new \Datetime($days . ' days ago');
    $listAdverts = $advertRepository->getAdvertsBefore($date);

    foreach ($listAdverts as $advert) {
      $advertSkills = $advertSkillRepository->findBy(array('advert' => $advert));
      foreach ($advertSkills as $advertSkill) {
        $this->em->remove($advertSkill);
      }
      $this->em->remove($advert);
    }
    $this->em->flush();
  }
}
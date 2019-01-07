<?php
/**
 * Created by PhpStorm.
 * User: ahmed.hadjtaieb
 * Date: 01/01/19
 * Time: 16:49
 */

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Application;

class LoadAdvert implements FixtureInterface {
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager) {

    for ($x = 0; $x <= 10; $x++) {
      $advert = new Advert();
      $advert->setTitle("title_advert_$x");
      $advert->setAuthor("author_advert_$x");
      $advert->setContent("content_advert_$x");
      if (in_array($x, [3, 6, 9])) {
        $application = new Application();
        $application->setAuthor("author_application_$x");
        $application->setContent("content_application_$x");
        $application->setAdvert($advert);
        $manager->persist($application);
      }
      $manager->persist($advert);
    }
    $manager->flush();
  }
}
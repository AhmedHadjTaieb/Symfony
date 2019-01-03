<?php
/**
 * Created by PhpStorm.
 * User: ahmed.hadjtaieb
 * Date: 03/01/19
 * Time: 15:02
 */

namespace OCPlatformBundle\DoctrineListener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use OCPlatformBundle\Email\ApplicationMailer;
use OC\PlatformBundle\Entity\Application;

class ApplicationCreationListener
{
  /**
   * @var ApplicationMailer
   */
  private $applicationMailer;

  public function __construct(ApplicationMailer $applicationMailer)
  {
    $this->applicationMailer = $applicationMailer;
  }

  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();

    // On ne veut envoyer un email que pour les entités Application
    if (!$entity instanceof Application) {
      return;
    }

    $this->applicationMailer->sendNewNotification($entity);
  }
}
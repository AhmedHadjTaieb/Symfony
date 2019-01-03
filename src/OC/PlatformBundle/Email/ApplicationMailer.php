<?php
/**
 * Created by PhpStorm.
 * User: ahmed.hadjtaieb
 * Date: 03/01/19
 * Time: 15:00
 */

namespace OCPlatformBundle\Email;


use OC\PlatformBundle\Entity\Application;

class ApplicationMailer
{
  /**
   * @var \Swift_Mailer
   */
  private $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  public function sendNewNotification(Application $application)
  {
    $message = new \Swift_Message(
      'Nouvelle candidature',
      'Vous avez reçu une nouvelle candidature.'
    );

    $message
      ->addTo($application->getAdvert()->getAuthor()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
      ->addFrom('ahmed.ht.92@gmail.com')
    ;

    $this->mailer->send($message);
  }
}

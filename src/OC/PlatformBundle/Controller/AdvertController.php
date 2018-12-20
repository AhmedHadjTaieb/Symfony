<?php
/**
 * Created by PhpStorm.
 * User: AhmedHt
 * Date: 14/12/2018
 * Time: 21:48
 */

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdvertController extends Controller {

  public function helloAction() {

    return $this->render('@OCPlatform/Advert/hello.html.twig', array('nom' => 'AhmedHt'));
  }

  public function byeAction() {

    return $this->render('@OCPlatform/Advert/bye.html.twig', array('nom' => 'AhmedHt'));
  }

}
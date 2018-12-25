<?php
/**
 * Created by PhpStorm.
 * User: AhmedHt
 * Date: 14/12/2018
 * Time: 21:48
 */

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class AdvertController extends Controller {

  public function indexAction() {

    return $this->render('@OCPlatform/Advert/hello.html.twig', array('nom' => 'AhmedHt'));
  }

  public function viewAction($id, Request $request) {
    $tag = $request->query->get('tag');
    return new Response(
      "Affichage de l'annonce d'id : " . $id . ", avec le tag : " . $tag
    );
  }

  public function addAction() {

    return $this->render('@OCPlatform/Advert/bye.html.twig', array('nom' => 'AhmedHt'));
  }

  public function editAction() {

    return $this->render('@OCPlatform/Advert/bye.html.twig', array('nom' => 'AhmedHt'));
  }

  public function deleteAction() {

    return $this->render('@OCPlatform/Advert/bye.html.twig', array('nom' => 'AhmedHt'));
  }

}
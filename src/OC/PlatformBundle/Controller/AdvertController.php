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
    $session = $request->getSession();
    $session->set('user_id', 91);
    $userId = $session->get('user_id');


    return $this->render('@OCPlatform/Advert/view.html.twig', array(
      'id' => $id,
      'tag' => $tag,
      'user_id' => $userId
    ));
  }

  public function addAction(Request $request) {
    $session = $request->getSession();

    $session->getFlashBag()->add('info', 'Bonjour Mr');
    return $this->redirectToRoute('oc_platform_view', array('id' => 5));
  }

  public function editAction() {

    return $this->render('@OCPlatform/Advert/bye.html.twig', array('nom' => 'AhmedHt'));
  }

  public function deleteAction() {

    return $this->render('@OCPlatform/Advert/bye.html.twig', array('nom' => 'AhmedHt'));
  }

}
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


class AdvertController extends Controller
{

  public function indexAction() {
    $listAdverts = array(
      array(
        'title' => 'Recherche développpeur Symfony',
        'id' => 1,
        'author' => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date' => new \Datetime()
      ),
      array(
        'title' => 'Mission de webmaster',
        'id' => 2,
        'author' => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date' => new \Datetime()
      ),
      array(
        'title' => 'Offre de stage webdesigner',
        'id' => 3,
        'author' => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date' => new \Datetime()
      )
    );
    return $this->render('@OCPlatform/Advert/index.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }

  public function viewAction($id) {
    $advert = array(
      'title' => 'Recherche développpeur Symfony2',
      'id' => $id,
      'author' => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date' => new \Datetime()
    );
    return $this->render('@OCPlatform/Advert/view.html.twig', array(
      'advert' => $advert
    ));
  }

  public function addAction(Request $request) {
      $antispam = $this->container->get('oc_platform.antispam');
      $text = '......';
      if ($antispam->isSpam($text)) {
          throw new \Exception('Votre message a été détecté comme spam !');
      }
    return $this->render('@OCPlatform/Advert/add.html.twig');
  }

  public function editAction($id) {
    $advert = array(
      'title' => 'Recherche développpeur Symfony2',
      'id' => $id,
      'author' => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date' => new \Datetime()
    );
    return $this->render('@OCPlatform/Advert/edit.html.twig', array('advert' => $advert));
  }

  public function deleteAction() {

    return $this->render('@OCPlatform/Advert/remove.html.twig', array('nom' => 'AhmedHt'));
  }

  public function menuAction() {
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('@OCPlatform/Advert/menu.html.twig', array('listAdverts' => $listAdverts));
  }

}
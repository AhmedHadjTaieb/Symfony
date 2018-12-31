<?php
/**
 * Created by PhpStorm.
 * User: AhmedHt
 * Date: 14/12/2018
 * Time: 21:48
 */

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller {

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
    $advert = $this->getDoctrine()
      ->getManager()
      ->find('OCPlatformBundle:Advert', $id);

    if (NULL === $advert) {
      throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
    }

    return $this->render('@OCPlatform/Advert/view.html.twig', array(
      'advert' => $advert
    ));
  }

  public function addAction(Request $request) {
    // Création de l'entité
    $advert = new Advert();
    $advert->setTitle('Recherche développeur Symfony.');
    $advert->setAuthor('Alexandre');
    $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

    $image = new Image();
    $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    $image->setAlt('Job de rêve');

    $advert->setImage($image);

    $em = $this->getDoctrine()->getManager();

    $em->persist($advert);

    $em->flush();

    if ($request->isMethod('POST')) {
      $request->getSession()
        ->getFlashBag()
        ->add('notice', 'Annonce bien enregistrée.');
      return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('@OCPlatform/Advert/add.html.twig', array('advert' => $advert));
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
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
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;

class AdvertController extends Controller {

  public function indexAction($page) {
    if ($page < 1) {
      throw new NotFoundHttpException('Page "' . $page . '" inexistante.');
    }

    $nbPages = 2;

    $listAdverts = $this->getDoctrine()->getManager()
      ->getRepository('OCPlatformBundle:Advert')->getAdverts($page, $nbPages);

    $nbPages = ceil(count($listAdverts) / $nbPages);

    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
    }
    return $this->render('@OCPlatform/Advert/index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages' => $nbPages,
      'page' => $page
    ));
  }

  public function viewAction($id) {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (NULL === $advert) {
      throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
    }
    $listApplications = $em
      ->getRepository('OCPlatformBundle:Application')
      ->findBy(array('advert' => $advert));

    $listAdvertSkills = $em
      ->getRepository('OCPlatformBundle:AdvertSkill')
      ->findBy(array('advert' => $advert));

    return $this->render('@OCPlatform/Advert/view.html.twig', array(
      'advert' => $advert,
      'listApplications' => $listApplications,
      'listAdvertSkills' => $listAdvertSkills
    ));

  }

  public function addAction(Request $request) {
    $advert = new Advert();
    $advert->setTitle('Recherche développeur Symfony.');
    $advert->setAuthor('Alexandre');
    $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

    $image = new Image();
    $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    $image->setAlt('Job de rêve');

    $advert->setImage($image);

    $em = $this->getDoctrine()->getManager();

    $listSkills = $em->getRepository('OCPlatformBundle:Skill')->findAll();

    foreach ($listSkills as $skill) {
      $advertSkill = new AdvertSkill();
      $advertSkill->setAdvert($advert);
      $advertSkill->setSkill($skill);
      $advertSkill->setLevel('Expert');
      $em->persist($advertSkill);
    }

    $application1 = new Application();
    $application1->setAuthor('Marine');
    $application1->setContent("J'ai toutes les qualités requises.");

    $application2 = new Application();
    $application2->setAuthor('Pierre');
    $application2->setContent("Je suis très motivé.");

    $application1->setAdvert($advert);
    $application2->setAdvert($advert);

    $em->persist($advert);

    $em->persist($application1);
    $em->persist($application2);

    $em->flush();

    if ($request->isMethod('POST')) {
      $request->getSession()
        ->getFlashBag()
        ->add('notice', 'Annonce bien ajouteé.');

      return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('@OCPlatform/Advert/add.html.twig', array('advert' => $advert));
  }

  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (NULL === $advert) {
      throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
    }

    $listCategories = $em->getRepository('OCPlatformBundle:Category')
      ->findAll();

    foreach ($listCategories as $category) {
      $advert->addCategory($category);
    }

    $em->flush();

    if ($request->isMethod('POST')) {
      $request->getSession()
        ->getFlashBag()
        ->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('@OCPlatform/Advert/edit.html.twig', array('advert' => $advert));
  }

  public function deleteAction($id) {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (NULL === $advert) {
      throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
    }

    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
    }

    $em->flush();


    return $this->render('@OCPlatform/Advert/remove.html.twig');
  }

  public function menuAction($limit) {
    $em = $this->getDoctrine()->getManager();

    $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->findBy(
      array(),
      array('date' => 'desc'),
      $limit,
      0
    );

    return $this->render('@OCPlatform/Advert/menu.html.twig', array('listAdverts' => $listAdverts));
  }

  public function editImageAction($advertId) {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($advertId);

    $advert->getImage()->setUrl('test.png');

    $em->flush();

    return new Response('OK');
  }

  public function purgeAdvertAction($days) {
    $purge = $this->container->get('oc_platform.purger.advert');
    $purge->purge($days);
  }
}
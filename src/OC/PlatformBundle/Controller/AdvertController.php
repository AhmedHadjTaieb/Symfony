<?php
/**
 * Created by PhpStorm.
 * User: AhmedHt
 * Date: 14/12/2018
 * Time: 21:48
 */

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Form\AdvertEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use OC\PlatformBundle\Form\AdvertType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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

  /**
   * @Security("has_role('ROLE_AUTEUR')")
   */
  public function addAction(Request $request) {
    $advert = new Advert;
    if (!$this->get('security.authorization_checker')
      ->isGranted('ROLE_AUTEUR')) {
      throw new AccessDeniedException('Accès limité aux auteurs.');
    }
    $form = $this->createForm(AdvertType::class, $advert);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $advert->setIpAddress($request->getClientIp());
        $ap = new Application();
        $ap->setAdvert($advert);
        $ap->setIpAddress($request->getClientIp());

        $ap->setAuthor('test author');
        $ap->setContent($advert->getContent());
        $em->persist($ap);
        $em->persist($advert);
        $em->flush();
        $request->getSession()
          ->getFlashBag()
          ->add('info', 'Annonce bien ajouteé.');

        return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));

      }
      else {
        // return new Response($form->getErrors());
      }
    }
    return $this->render('@OCPlatform/Advert/add.html.twig', array('form' => $form->createView()));
  }

  public function editAction($id, Request $request) {
    $advert = $this->getDoctrine()
      ->getManager()
      ->getRepository('OCPlatformBundle:Advert')
      ->find($id);
    if (NULL === $advert) {
      throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
    }


    $form = $this->createForm(AdvertEditType::class, $advert);


    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush();
        $request->getSession()
          ->getFlashBag()
          ->add('notice', 'Annonce bien modifiée.');

        return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
      }
    }
    return $this->render('@OCPlatform/Advert/edit.html.twig', array(
      'form' => $form->createView(),
      'advert' => $advert
    ));
  }

  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

    if (NULL === $advert) {
      throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)
        ->isValid()) {

      /* foreach ($advert->getCategories() as $category) {
         $advert->removeCategory($category);
       }*/

      $em->remove($advert);
      $em->flush();

      $request->getSession()
        ->getFlashBag()
        ->add('info', "L'annonce a bien été supprimée.");

      return $this->redirectToRoute('oc_platform_home');
    }

    return $this->render('@OCPlatform/Advert/remove.html.twig', array(
      'advert' => $advert,
      'form' => $form->createView(),
    ));
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

  public function purgeAdvertAction($days, Request $request) {
    $purge = $this->container->get('oc_platform.purger.advert');
    $purge->purge($days);
    $request->getSession()
      ->getFlashBag()
      ->add('info', 'Les annonces plus vieilles que ' . $days . ' jours ont été purgées.');
    return $this->redirectToRoute('oc_platform_home');
  }
}
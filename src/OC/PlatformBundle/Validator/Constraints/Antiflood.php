<?php
/**
 * Created by PhpStorm.
 * User: ahmed.hadjtaieb
 * Date: 10/01/19
 * Time: 14:03
 */

namespace OCPlatformBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Antiflood extends Constraint {

  public $message = "Vous avez déjà posté un message il y a moins de 15 secondes, merci d'attendre un peu.";

  public function validatedBy() {
    return 'oc_platform_antiflood';
  }

  public function getTargets() {
    return self::PROPERTY_CONSTRAINT;
  }
}
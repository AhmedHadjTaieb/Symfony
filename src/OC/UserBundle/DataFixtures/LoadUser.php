<?php
/**
 * Created by PhpStorm.
 * User: ahmed.hadjtaieb
 * Date: 11/01/19
 * Time: 14:49
 */

namespace OC\UserBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\UserBundle\Entity\User;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Les noms d'utilisateurs à créer
        $listNames = array('Alexandre', 'Marine', 'Anna');

        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user = new User;

            // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
            $user->setUsername($name);
            $user->setPlainPassword($name);
            $user->setEnabled(true);
            // On ne se sert pas du sel pour l'instant
            $user->setSalt('');
            // On définit uniquement le role ROLE_USER qui est le role de base

            $user->setEmail($name . '@test.com');
            if ($name === 'Marine')
                $user->setRoles(array('ROLE_AUTEUR'));

            else
                $user->setRoles(array('ROLE_ADMIN'));

            // On le persiste
            $manager->persist($user);
        }

        // On déclenche l'enregistrement
        $manager->flush();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: AhmedHt
 * Date: 12/01/2019
 * Time: 10:39
 */

namespace OCPlatformBundle\Twig;

use OC\PlatformBundle\Antispam\OCAntispam;


class AntispamExtension extends \Twig_Extension
{
    /**
     * @var OCAntispam
     */
    private $ocAntispam;

    public function __construct(OCAntispam $ocAntispam)
    {
        $this->ocAntispam = $ocAntispam;
    }

    public function checkIfArgumentIsSpam($text)
    {
        return $this->ocAntispam->isSpam($text);
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('checkIfSpam', array($this, 'checkIfArgumentIsSpam')),
        );
    }

    public function getName()
    {
        return 'OCAntispam';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: AhmedHt
 * Date: 12/01/2019
 * Time: 11:59
 */

namespace OCPlatformBundle\Beta;


use Symfony\Component\HttpFoundation\Response;

class BetaHTMLAdder
{
    public function addBeta(Response $response, $remainingDays)
    {
        $content = $response->getContent();


        $html = '<div style="position: relative; top: 0; background: orange; width: 90%; text-align: center; padding: 0.5em; margin:0 auto;">Beta J-'.(int) $remainingDays.' !</div>';

        // Insertion du code dans la page, au début du <body>
        $content = str_replace(
            '<body>',
            '<body> '.$html,
            $content
        );

        // Modification du contenu dans la réponse
        $response->setContent($content);

        return $response;
    }
}
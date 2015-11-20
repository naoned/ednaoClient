<?php

namespace Naoned\ednaoClient;

/**
*
*/
class Iframe
{
    public function render($socle, $version, $product, $group, $accessLevel, $page)
    {
        $token = 'test';
        return sprintf(
            '
            <iframe
                src="http://vbeauvivre.insitu.help.mnesys.fr/%s/%s/%s"
                frameborder="1" marginheight="0" marginwidth="0"
                width="400" height="600"
                id="ednao"
            >
              <p>Votre navigateur ne supporte pas l’élément iframe, l’aide ne peut donc pas être affichée</p>
            </iframe>',
            $token,
            $version,
            $page
        );
    }
}

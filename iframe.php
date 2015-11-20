<?php

namespace Naoned\ednaoClient;

/**
*
*/
class Iframe
{
    public function render($url, $socle, $version, $product, $group, $accessLevel, $page)
    {
        $token = 'test';
        return sprintf(
            '
            <iframe
                src="%s"
                frameborder="1" marginheight="0" marginwidth="0"
                width="400" height="600"
                id="ednao"
            >
              <p>Votre navigateur ne supporte pas l’élément iframe, l’aide ne peut donc pas être affichée</p>
            </iframe>',
            $url,
            $token,
            $version,
            $page
        );
    }
}

<?php

namespace Naoned\EdnaoClient;

use Naoned\EdnaoClient\Security\Cryptography\EdnaoCryptography;
use Naoned\EdnaoClient\Manager\TokenManager;
use Naoned\EdnaoClient\Model\Token;

/**
*     Create the iFrame to access help
*/
class Iframe
{
    public function render($url, $socle, $version, $product, array $rights, $page)
    {
        $token = new Token($socle, $product, $rights);
        $ednaoCrypt = new EdnaoCryptography();
        $tokenManager = new TokenManager($ednaoCrypt);
        $encodedToken = $tokenManager->getTokenCrypt($token);

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
            $encodedToken,
            $version,
            $page
        );
    }
}

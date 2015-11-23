<?php

namespace Naoned\EdnaoClient;

use Naoned\EdnaoClient\Security\Cryptography\EdnaoCryptography;
use Naoned\EdnaoClient\Manager\TokenManager;
use Naoned\EdnaoClient\Model\Token;

/**
*     Create the iFrame to access help
*/
class Renderer
{
    const CONTEXT_PATH = 'context2';

    public function iframe($baseUrl, $socle, $version, $product, array $rights, $page)
    {
        $token = new Token($socle, $product, $rights);
        $ednaoCrypt = new EdnaoCryptography();
        $ednaoCrypt->setPublicKey(file_get_contents(__DIR__ . '/../../var/auth/public.pem'));
        $tokenManager = new TokenManager($ednaoCrypt);
        $encodedToken = $tokenManager->getTokenCrypt($token);
        //
        $url = sprintf(
            '%s/naoned/%s/%s/%s',
            $baseUrl,
            $encodedToken,
            urlencode($version),
            urlencode($page)
        );

        return sprintf(
            '
            <a href="%1$s">%1$s</a>
            <iframe
                src="%1$s"
                frameborder="1" marginheight="0" marginwidth="0"
                width="400" height="600"
                id="ednao"
                data-base-url="%2$s"
                data-context-path="%3$s"
            >
              <p>Votre navigateur ne supporte pas l’élément iframe, l’aide ne peut donc pas être affichée</p>
            </iframe>',
            $url,
            $baseUrl,
            self::CONTEXT_PATH
        );
    }
}

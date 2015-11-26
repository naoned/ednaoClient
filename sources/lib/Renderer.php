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
    const CONTEXT_PATH = '/contextual-list?c=';

    public static function iframe($baseUrl, $socle, $version, $product, array $rights, $page)
    {
        $token = new Token($socle, $product, $rights);
        $ednaoCrypt = new EdnaoCryptography();
        $ednaoCrypt->setPublicKey(file_get_contents(__DIR__ . '/../../var/auth/public.pem'));
        $tokenManager = new TokenManager($ednaoCrypt);
        $encodedToken = $tokenManager->getTokenCrypt($token);
        $loginUrl = sprintf(
            '/naoned/%s/%s/%s',
            $encodedToken,
            urlencode($version),
            urlencode($page)
        );

        return sprintf(
            '<iframe
            src=""
            frameborder="1" marginheight="0" marginwidth="0"
            width="400" height="600"
            id="ednao"
            data-login-path="%s"
            data-base-url="%s"
            data-context-path="%s"
            style="%s"
            >
            <p>Votre navigateur ne supporte pas l’élément iframe,
              l’aide ne peut donc pas être affichée</p>
            </iframe>',
            $loginUrl,
            $baseUrl,
            self::CONTEXT_PATH,
            self::style()
        );
    }

    public static function style()
    {
        return '
        width:400px;
        height:600px;
        position:fixed;
        top: 100px;
        left: 300px;
        border:3px solid #086096;
        box-shadow: 0 3px 8px 4px rgba(0, 0, 0, 0.4);
        border: 0;
        display: none;
        ';

    }

    public static function styleDefinition()
    {
        return sprintf(
            '#ednao { %s }',
            self::style()
        );
    }
}

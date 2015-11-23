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

    public static function iframe($baseUrl, $socle, $version, $product, array $rights, $page)
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
            <div draggable="true" id="ednao">
                <div id="ednao-handle">Aide Naoned</div>
                <iframe
                    src="%1$s"
                    frameborder="1" marginheight="0" marginwidth="0"
                    width="400" height="600"
                    id="ednao-iframe"
                    data-base-url="%2$s"
                    data-context-path="%3$s"
                >
                  <p>Votre navigateur ne supporte pas l’élément iframe, l’aide ne peut donc pas être affichée</p>
                </iframe>
            </div>',
            $url,
            $baseUrl,
            self::CONTEXT_PATH
        );
    }

    public static function style()
    {
        return '
#ednao {
  position:absolute;
  top: 100px;
  left: 600px;
  border:3px solid #086096;
  box-shadow: 0 0 32px 8px rgba(0, 0, 0, 0.5);
  background: #E5E5E5;
  border-radius: 8px 8px 0 0;
}
#ednao-handle {
  background: #086096;
  color: #FFF;
  padding: .2em;
  cursor: move;
}
#ednao-iframe {
  border: 0;
}';

    }
}

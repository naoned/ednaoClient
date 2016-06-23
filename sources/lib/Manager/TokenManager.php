<?php

namespace Naoned\EdnaoClient\Manager;

use Naoned\EdnaoClient\Security\Cryptography\EdnaoCryptography;
use Naoned\EdnaoClient\Model\Token;

class TokenManager
{

    /**
     * @var EdnaoCryptography
     */
    private $ednaoCrypt;

    public function __construct(EdnaoCryptography $ednaoCrypt)
    {
        $this->ednaoCrypt = $ednaoCrypt;
    }

    public function getTokenCrypt(Token $token)
    {
        // Requires "AllowEncodedSlashes On" in apache virtualhost.
        // Double encoded because some utf8 characters can make Apache crash.
        // Apache automatically decodes the first encode and then still sees an encoded string.
        return rawurlencode(rawurlencode($this->ednaoCrypt->crypt($token->serialize())));
    }

    public function getTokenDecrypt($str)
    {
        return Token::unserialize($this->ednaoCrypt->decrypt(rawurldecode($str)));
    }
}

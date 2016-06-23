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
        return rawurlencode($this->ednaoCrypt->crypt($token->serialize()));
    }

    /**
     * Get decrypted token
     * @param  string $str Encoded token
     * @return Array       Token data array
     */
    public function getTokenDecrypt($str)
    {
        $token = Token::unserialize($this->ednaoCrypt->decrypt($str));

        if (!$token) {
            // Compatibility with old encoding of the token
            $token = Token::unserialize($this->ednaoCrypt->decrypt(urldecode($str)));
        }

        return Token::unserialize($this->ednaoCrypt->decrypt($str));
    }
}

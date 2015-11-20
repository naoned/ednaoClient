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
        return urlencode($this->ednaoCrypt->crypt($token->serialize()));
    }

    public function getTokenDecrypt($str)
    {
        return Token::unserialize($this->ednaoCrypt->decrypt(urldecode($str)));
    }

}
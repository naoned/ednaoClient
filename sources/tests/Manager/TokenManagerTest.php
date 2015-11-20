<?php

namespace Naoned\EdnaoClient\Test\Manager;

use Naoned\EdnaoClient\Manager\TokenManager;
use Naoned\EdnaoClient\Model\Token;
use Naoned\EdnaoClient\Security\Cryptography\EdnaoCryptography;

class TokenManagerTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $token = new Token(
            'inao',
            'archives',
            [
                'group1' => 'right1'
            ]
        );

        $ednaoCrypt = new EdnaoCryptography();
        $tokenManager = new TokenManager($ednaoCrypt);

        $crypt = $tokenManager->getTokenCrypt($token);
        $uncryptToken = $tokenManager->getTokenDecrypt($crypt);

        $this->assertEquals($token->serialize(), $uncryptToken->serialize());
    }
}

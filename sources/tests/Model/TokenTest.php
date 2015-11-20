<?php

namespace Naoned\EdnaoClient\Test\Model;

use Naoned\EdnaoClient\Model\Token;

class TokenTest extends \PHPUnit_Framework_TestCase
{
    private static $socle = 'inao';
    private static $product = 'archives';
    private static $right = [
        'group1' => 'right1'
    ] ;

    private static $serializedToken;

    public function testSerialize()
    {
        $token = new Token(self::$socle, self::$product, self::$right);

        self::$serializedToken = $token->serialize();

        $this->assertNotEmpty(self::$serializedToken);
    }


    public function testUnserialize()
    {
        $token = Token::unserialize(self::$serializedToken);

        $this->assertEquals(get_class($token), 'Naoned\EdnaoClient\Model\Token');

        $this->assertEquals($token->getSocle(), self::$socle);
        $this->assertEquals($token->getProduct(), self::$product);
        $this->assertEquals(serialize($token->getRight()), serialize(self::$right));
    }
}
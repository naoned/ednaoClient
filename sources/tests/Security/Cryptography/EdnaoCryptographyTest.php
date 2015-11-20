<?php

namespace Naoned\EdnaoClient\Test\Security\Cryptography;

use Naoned\EdnaoClient\Security\Cryptography\EdnaoCryptography;

class EdnaoCryptographyTest extends \PHPUnit_Framework_TestCase
{
    public function testCryptDecrypt()
    {
        $str = 'Ceci est un test hyper important !!';

        $ec = new EdnaoCryptography();
        $encoded = $ec->crypt($str);
        $decoded = $ec->decrypt($encoded);

        $this->assertNotEmpty($encoded);
        $this->assertEquals($str, $decoded);
    }
}
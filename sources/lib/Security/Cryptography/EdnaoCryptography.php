<?php

namespace Naoned\EdnaoClient\Security\Cryptography;

use phpseclib\Crypt\RSA;


class EdnaoCryptography
{
    /**
     * @var RSA
     */
    private $rsa;

    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $privateKey;

    public function __construct($publicKey = '', $privateKey = '')
    {
        $this->rsa =  new RSA();

        if (!$publicKey || !$privateKey) {
            $keys = $this->rsa->createKey();
            $this->publicKey  = $keys['publickey'];
            $this->privateKey = $keys['privatekey'];
            return;
        }
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * Encode a string
     *
     * @param $str
     * @return String
     */
    public function crypt($str)
    {
        $this->loadPublicKey();
        return $this->rsa->encrypt($str);
    }

    /**
     * Decode a string
     *
     * @param $str
     * @return String
     */
    public function decrypt($str)
    {
        $this->loadPrivateKey();
        return $this->rsa->decrypt($str);
    }

    /**
     * Load public key into RSA crypt system (in order to encode)
     */
    private function loadPublicKey()
    {
        $this->rsa->loadKey($this->publicKey);
    }

    /**
     * Load private key into RSA crypt system (in order to decode)
     */
    private function loadPrivateKey()
    {
        $this->rsa->loadKey($this->privateKey);
    }
}
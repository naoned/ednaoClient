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

    const RANDOM_CHAR_POSITION = 10;

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

    /**
     * @deprecated We don't encode with keys anymore
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @deprecated We don't encode with keys anymore
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     * @deprecated We don't encode with keys anymore
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * Encode a string into base64
     * and insert a random char at RANDOM_CHAR_POSITION position
     *
     * @param String $str
     * @return String
     */
    public function crypt($str)
    {
        $char   = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')[0];
        $output = base64_encode($str);

        return substr($output, 0, self::RANDOM_CHAR_POSITION) . $char . substr($output, self::RANDOM_CHAR_POSITION);
    }

    /**
     * Decode a string
     *
     * @param String $str
     * @return String
     */
    public function decrypt($str)
    {
        $base64Token = base64_decode(substr($str, 0, self::RANDOM_CHAR_POSITION) . substr($str, self::RANDOM_CHAR_POSITION + 1));

        if (!$base64Token) {
            // Compatibility for old encoding method
            $this->loadPrivateKey();

            return $this->rsa->decrypt($str);
        }

        return $base64Token;
    }

    /**
     * Load public key into RSA crypt system (in order to encode)
     * @deprecated We don't encode with keys anymore
     */
    private function loadPublicKey()
    {
        $this->rsa->loadKey($this->publicKey);
    }

    /**
     * Load private key into RSA crypt system (in order to decode)
     * @deprecated We don't encode with keys anymore
     */
    private function loadPrivateKey()
    {
        $this->rsa->loadKey($this->privateKey);
    }
}

<?php

namespace Naoned\EdnaoClient\Model;

class Token
{
    /**
     * @var string
     */
    private $socle;

    /**
     * @var string
     */
    private $product;

    /**
     * @var array
     */
    private $rights;

    public function __construct($socle, $product, array $rights)
    {
        $this->socle = $socle;
        $this->product = $product;
        $this->rights = $rights;
    }

    /**
     * @return string
     */
    public function getSocle()
    {
        return $this->socle;
    }

    /**
     * @param string $socle
     * @return Token
     */
    public function setSocle($socle)
    {
        $this->socle = $socle;
        return $this;
    }

    /**
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $product
     * @return Token
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return array
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param array $rights
     * @return Token
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
        return $this;
    }



    /**
     * Serialize actual token
     *
     * @return string
     */
    public function serialize()
    {
        $s = [
            'socle'   => $this->socle,
            'product' => $this->product,
            'rights'  => $this->rights,
        ];

        return json_encode($s);
    }

    /**
     * Unserialize string to hydrate and return an instance of Token
     *
     * @param  String $str
     * @return Token       Token object
     */
    public static function unserialize($str)
    {
        $t = json_decode($str, true);

        if (!$t) {
            // Compatibility for old serialize versions
            $t = unserialize($str);
        }

        if (!isset($t['socle']) || !isset($t['product']) || !isset($t['rights'])) {
            throw new \Exception('Unserialized string does not refer to a valid token');
        }

        return new Token($t['socle'], $t['product'], $t['rights']);
    }
}

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
    private $right;

    public function __construct($socle, $product, array $right)
    {
        $this->socle = $socle;
        $this->product = $product;
        $this->right = $right;
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
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param array $right
     * @return Token
     */
    public function setRight($right)
    {
        $this->right = $right;
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
            'right'   => $this->right
        ];
        return serialize($s);
    }

    /**
     * Unserialize string to hydrate and return an instance of Token
     *
     * @param $str
     */
    public static function unserialize($str)
    {
        $t = unserialize($str);

        if (!isset($t['socle']) || !isset($t['product']) || !isset($t['right'])) {
            throw new \Exception('Unserialized string doe\'nt refer to a valid token');
        }
        return new Token($t['socle'], $t['product'], $t['right']);
    }

}
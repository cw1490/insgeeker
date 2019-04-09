<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/5
 * Time: 10:04 AM
 */
namespace OpenClose\V1;

class Iphone implements IApple
{

    private $id;
    private $name;
    private $price;

    public function __construct($id, $name, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function toString()
    {
        return '商品id: ' . $this->getId() . '; 商品名称: ' . $this->getName() . '; 商品价格: ' . $this->getPrice() . PHP_EOL;
    }

}


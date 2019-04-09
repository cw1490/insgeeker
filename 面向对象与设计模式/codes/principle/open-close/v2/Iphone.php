<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/5
 * Time: 10:04 AM
 */
namespace OpenClose\V2;

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

    public function getDiscountPrice()
    {
        return $this->price * 0.8;
    }




}


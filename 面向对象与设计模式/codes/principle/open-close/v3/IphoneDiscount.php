<?php

namespace OpenClose\V3;

class IphoneDiscount extends Iphone
{
    public function getPrice()
    {
        return parent::getPrice() * 0.8;
    }

    public function getOriginPrice()
    {
        return parent::getPrice();
    }

    public function toString()
    {
        return '商品id: ' . $this->getId()
            . '; 商品名称: ' . $this->getName()
            . '; 商品价格: ' . $this->getPrice()
            . '; 商品原价: ' . $this->getOriginPrice()
            . PHP_EOL;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/5
 * Time: 10:01 AM
 */
namespace OpenClose\V2;
interface IApple
{

    public function getId();
    public function getName();
    public function getPrice();
    public function getDiscountPrice();
}
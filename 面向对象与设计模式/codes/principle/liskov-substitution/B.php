<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/17
 * Time: 10:46 AM
 */

class B extends A
{

    public function func1($a, $b)
    {
        return $a + $b;
    }

    public function func2($a, $b)
    {
        return $this->func1($a, $b) + 100;
    }
}
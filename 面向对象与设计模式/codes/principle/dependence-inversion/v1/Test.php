<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/9
 * Time: 9:57 AM
 */
namespace di\v1;

require_once "Xin.php";

class Test
{
    public static function run()
    {

        $xin = new Xin();
        $xin->grabBoosData();
        $xin->grabMaiData();
    }
}

Test::run();
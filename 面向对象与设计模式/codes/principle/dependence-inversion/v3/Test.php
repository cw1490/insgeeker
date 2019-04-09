<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/9
 * Time: 10:41 AM
 */

namespace di\v3;

require_once "IGrab.php";
require_once "GrabBossData.php";
require_once "GrabMaiData.php";
require_once "Xin.php";


class Test
{

    public static function run()
    {

        $xin = new Xin();
        $xin->set(new GrabBossData());
        $xin->grabData();

        $xin->set(new GrabMaiData());
        $xin->grabData();
    }
}

Test::run();
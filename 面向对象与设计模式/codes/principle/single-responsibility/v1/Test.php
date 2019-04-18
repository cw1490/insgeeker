<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/9
 * Time: 11:59 AM
 */

namespace sr\v1;
require_once "Bird.php";

class Test
{

    public static function run()
    {
        $bird = new Bird();
        $bird->move("大雁");
        $bird->move("企鹅");
    }
}

Test::run();
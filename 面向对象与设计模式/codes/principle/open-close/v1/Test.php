<?php
require_once "IApple.php";
require_once "Iphone.php";

use OpenClose\V1\Iphone;

class Test
{

    public static function run() {
        $max = new Iphone(99, 'iPhone XS Max', 9099);
        print_r($max->toString());
    }

}

Test::run();

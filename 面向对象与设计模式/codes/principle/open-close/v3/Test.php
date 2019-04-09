<?php
require_once "IApple.php";
require_once "Iphone.php";
require_once "IphoneDiscount.php";

use OpenClose\V3\IphoneDiscount;

class Test
{

    public static function run() {

        $max = new IphoneDiscount(99, 'iPhone XS Max', 9099);
        print_r($max->toString());
    }
}

Test::run();

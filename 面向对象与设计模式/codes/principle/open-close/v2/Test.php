<?php
require_once "IApple.php";
require_once "Iphone.php";
require_once "IphoneDiscount.php";

use OpenClose\V2\Iphone;

class Test
{

    /**
     *
     */
    public static function run() {

        $max = new Iphone(99, 'iPhone XS Max', 9099);
        print_r($max->toString());
    }
}

Test::run();

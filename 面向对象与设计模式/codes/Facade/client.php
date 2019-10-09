<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/5/28
 * Time: 5:34 PM
 */
include_once "Facade/Computer.php";

class client
{

    public function run()
    {
        $computer = new Computer();
        echo 111;
        $computer->start();

        $computer->shutDown();
    }
}

(new client())->run();
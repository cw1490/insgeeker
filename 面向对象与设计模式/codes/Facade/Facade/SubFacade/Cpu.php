<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/5/28
 * Time: 5:30 PM
 */
include_once "IFacade.php";
class Cpu implements IFacade
{

    public function start()
    {
        echo "CPU is start...", PHP_EOL;
    }

    public function shutDown()
    {
        echo "CPU is shutDown...", PHP_EOL;
    }
}
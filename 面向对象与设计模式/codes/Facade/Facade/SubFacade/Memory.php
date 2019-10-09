<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/5/28
 * Time: 5:30 PM
 */
include_once "IFacade.php";
class Memory implements IFacade
{

    public function start()
    {
        echo "Memory is start...", PHP_EOL;
    }

    public function shutDown()
    {
        echo "Memory is shutDown...", PHP_EOL;
    }
}
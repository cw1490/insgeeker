<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/5/28
 * Time: 5:30 PM
 */
include_once "IFacade.php";
class Disk implements IFacade
{

    public function start()
    {
        echo "Disk is start...", PHP_EOL;
    }

    public function shutDown()
    {
        echo "Disk is shutDown...", PHP_EOL;
    }
}
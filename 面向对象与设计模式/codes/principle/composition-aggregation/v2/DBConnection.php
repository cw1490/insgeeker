<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/15
 * Time: 3:32 PM
 */

namespace ca\v2;


abstract class DBConnection
{
    public abstract function getConnection();
}
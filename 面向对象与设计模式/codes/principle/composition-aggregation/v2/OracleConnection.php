<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/15
 * Time: 3:34 PM
 */

namespace ca\v2;


class OracleConnection extends DBConnection
{

    public function getConnection()
    {
        return "Oracle数据库连接";
    }
}
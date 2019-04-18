<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/15
 * Time: 3:38 PM
 */

namespace ca\v2;
require_once "DBConnection.php";
require_once "MySQLConnection.php";
require_once "OracleConnection.php";
require_once "UserDao.php";


class Test
{

    public static function run()
    {
        $userDao = new UserDao();
        $userDao->setDBConnection(new OracleConnection());
        $userDao->addUser();
    }

}

Test::run();
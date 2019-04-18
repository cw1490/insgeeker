<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/15
 * Time: 3:27 PM
 */

namespace ca\v1;
require_once "DBConnection.php";
require_once "UserDao.php";

class Test
{

    public static function run()
    {
        $userDao = new UserDao();
        $userDao->addUser();
    }
}

Test::run();
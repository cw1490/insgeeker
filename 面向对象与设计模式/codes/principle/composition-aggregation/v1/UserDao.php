<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/15
 * Time: 3:21 PM
 */

namespace ca\v1;


class UserDao extends DBConnection
{

    public function addUser() {

        $conn = parent::getConnection();
        echo "使用", $conn, "添加用户";
    }
}
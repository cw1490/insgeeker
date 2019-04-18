<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/15
 * Time: 3:35 PM
 */

namespace ca\v2;


class UserDao
{

    private $dbConnect;

    public function setDBConnection(DBConnection $connection)
    {
        $this->dbConnect = $connection;
    }

    public function addUser() {
        $conn = $this->dbConnect->getConnection();
        echo "使用", $conn, "添加用户";
    }
}
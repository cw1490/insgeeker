<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/9
 * Time: 10:43 AM
 */

namespace di\v2;

class Xin
{

    public function grabData(IGrab $grab) {
        $grab->grabData();
    }
}
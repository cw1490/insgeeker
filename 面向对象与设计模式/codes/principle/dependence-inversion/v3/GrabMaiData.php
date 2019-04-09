<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/9
 * Time: 10:31 AM
 */

namespace di\v3;


class GrabMaiData implements IGrab
{

    public function grabData()
    {

        echo "抓取脉数据" . PHP_EOL;
    }
}
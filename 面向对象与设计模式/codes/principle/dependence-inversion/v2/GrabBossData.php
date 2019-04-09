<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/9
 * Time: 10:41 AM
 */

namespace di\v2;


class GrabBossData implements IGrab
{

    public function grabData()
    {
        echo "抓取 boss 直聘数据" . PHP_EOL;
    }
}
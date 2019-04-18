<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/10
 * Time: 4:34 PM
 */

namespace demeter\v1;


class Manager
{

    public function getClaimListCount(ClaimList $claimList)
    {
        echo "当前的理赔案件数量为：", count($claimList), PHP_EOL;
    }
}
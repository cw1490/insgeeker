<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/10
 * Time: 4:38 PM
 */

namespace demeter\v1;


class Boss
{

    public function commandGetCLCount(Manager $manager)
    {
        $claimList = (new ClaimList())->getClaimList();
        $manager->getClaimListCount($claimList);
    }
}
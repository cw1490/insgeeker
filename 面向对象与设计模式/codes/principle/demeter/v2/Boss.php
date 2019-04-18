<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/10
 * Time: 4:38 PM
 */

namespace demeter\v2;


class Boss
{

    /**
     * @param Manager $manager
     */
    public function commandGetCLCount(Manager $manager)
    {

        $manager->getClaimListCount();
    }
}
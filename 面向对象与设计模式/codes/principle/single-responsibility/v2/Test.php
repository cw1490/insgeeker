<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/10
 * Time: 11:29 AM
 */

namespace sr\v2;
require_once "FlyBird.php";
require_once "WalkBird.php";

class Test
{

    public function run()
    {

        $flyBird = new FlyBird();
        $flyBird->move('大雁');

        $walkBird = new WalkBird();
        $walkBird->move('企鹅');
    }
}


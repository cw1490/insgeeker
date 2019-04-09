<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 2019/4/9
 * Time: 10:43 AM
 */

namespace di\v3;

class Xin
{

    private $grab;

    public function set(IGrab $grab) {
        $this->grab = $grab;
    }
    public function grabData() {
        $this->grab->grabData();
    }
}
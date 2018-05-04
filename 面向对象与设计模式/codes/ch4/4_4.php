<?php
class person{
    public $name;
}
$p1 = new person();
$p1->name = "少爷";

$p2 = clone $p1;
$p2->name = "弯弯";

var_dump($p1);
var_dump($p2);
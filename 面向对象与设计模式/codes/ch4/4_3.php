<?php 
class person {}
$p1 = new person();
$p2 = $p1; // `$p1` 和 `$p2` 指向同一个对象

var_dump($p1);
var_dump($p2);
<?php
class address {
	public $palace;
}
class person{
	public $name;
	public $address;
}
	
$address = new address();
$address->palace = "山东";

$p1 = new person();
$p1->name = "少爷";
$p1->address = $address; // 引用类型的赋值
	
$p2 = clone $p1;

echo "修改前：". "\n";
echo "p1 name = ".$p1->name." p1 palace = ".$p1->address->palace. "\n";
echo "p2 name = ".$p2->name." p2 palace = ".$p2->address->palace. "\n";

	
$p2->address->palace = "河北"; // 引用类型的赋值
$p2->name = "弯弯";

echo "修改后：". "\n";
echo "p1 name = ".$p1->name." p1 palace = ".$p1->address->palace. "\n";
echo "p2 name = ".$p2->name." p2 palace = ".$p2->address->palace. "\n";

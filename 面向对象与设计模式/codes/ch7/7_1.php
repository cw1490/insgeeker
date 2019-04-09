<?php

abstract class Beverage
{
	public $description;

	public function getDescription()
	{
		return $this->description;
	}

	abstract function cost();
}

//这是调味料的接口（抽象装饰）
abstract class CondimentDecorator extends Beverage
{

}

// 深焙咖啡类
class DarkRoast extends Beverage
{
	public function __construct()
	{
		$this->description = 'This is DarkRoast';
	}

	public function cost()
	{
		return 2.99;
	}
}

//一种饮料 (被装饰者)
class Espresso extends Beverage
{
	public function __construct()
	{
		$this->description = 'This is Espresso';
	}

	public function cost()
	{
		return 1.99;
	}
}

//另一种饮料(被装饰者)
class HouseBlend extends Beverage
{
	public function __construct()
	{
		$this->description = 'This is HouseBlend';
	}

	public function cost()
	{
		return 3.00;
	}
}

//以下是调味料(装饰者)
class Mocha extends CondimentDecorator
{
	public $beverage; //实例变量

	public function __construct(Beverage $beverage)
	{
		$this->beverage = $beverage;
	}

	public function getDescription()
	{
		return $this->beverage->getDescription().' + Mocha';
	}

	public function cost()
	{
		return .20 + $this->beverage->cost();
	}
}

echo "-------------------------\n";
$dr = new DarkRoast();
echo "DarkRoast 详情：\n";
echo "简介：".$dr->getDescription();
echo "\n价格：".$dr->cost();
echo "\n我要加些调味料：Mocha \n";
$m = new Mocha($dr);
echo "简介：".$k = $m->getDescription();
echo "\n价格：".$m->cost();
//var_dump($m);

echo "\n\n-------------------------\n";
$a = new HouseBlend();
echo "HouseBlend 详情：\n";
echo "简介：".$a->getDescription();
echo "\n价格：".$a->cost();
echo "\n我要加些调味料：Mocha \n";
$m = new Mocha($a);
echo "简介：".$k = $m->getDescription();
echo "\n价格：".$m->cost();
//var_dump($m);

echo "\n\n-------------------------\n";
$b = new Espresso();
echo "Espresso 详情：\n";
echo "简介：".$b->getDescription();
echo "\n价格：".$b->cost();
echo "\n我要加些调味料：Mocha \n";
$m = new Mocha($b);
echo "简介：".$k = $m->getDescription();
echo "\n价格：".$m->cost();
//var_dump($m);
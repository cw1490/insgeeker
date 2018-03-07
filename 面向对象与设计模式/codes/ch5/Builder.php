<?php
/**
 * 产品
 * 此处仅以一个产品类中的字符串演示产品
 */
class Product {
	/**
	 * 产品的组成部分集合
	 */
	private $_parts;
 
	public function __construct() {
		$this->_parts = array();
	}
 
	public function add($part) {
		return array_push($this->_parts, $part);
	}
 
	public function show() {
		echo "the product include:";
		array_map('printf', $this->_parts);
	}
}
 
/**
 * 抽象建造者 
 */
abstract class Builder {
 
	/**
	 * 产品零件构造方法1
	 */
	public abstract function buildPart1();
 
 
	/**
	 * 产品零件构造方法2
	 */
	public abstract function buildPart2();
 
 
	/**
	 * 产品返还方法
	 */
	public abstract function getResult();
}
 
/**
 * 具体建造者
 */
class ConcreteBuilder extends Builder {
 
	private $_product;
 
	public function __construct() {
		$this->_product = new Product();
	}
 
	public function buildPart1() {
		$this->_product->add("Part1");
	}
 
	public function buildPart2() {
		$this->_product->add("Part2");
	}
 
	public function getResult() {
		return $this->_product;
	}
}
 
/**
 * 导演者
 */
class Director {
 
	public function __construct(Builder $builder) {
		$builder->buildPart1();
		$builder->buildPart2();
	}
}
 
 
 
class Client {
 
	/**
	 * Main program.
	 */
	public static function main() {
		$buidler = new ConcreteBuilder();
		$director = new Director($buidler);
		$product = $buidler->getResult();
		$product->show();
	}
 
}
 
Client::main();
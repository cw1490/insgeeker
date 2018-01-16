<?php
	// 抽象工厂
	interface abstractFactory {
		// 创建等级结构为A的产品的工厂方法
		public function createProductA();
		// 创建等级结构为B的产品的工厂方法
		public function createProductB();
	}
	// 具体工厂1
	class concreteFactory1 implements abstractFactory{
		public function createProductA() {
			return new productA1();
		} 
		public function createProductB() {
			return new productB1();
		}
	}
	// 具体工厂2
	class concreteFactory2 implements abstractFactory{
		public function createProductA() {
			return new productA2();
		}
		public function createProductB() {
			return new productB2();
		}
	}
	 
	// 抽象产品A
	interface abstractProductA {
		public function getName();
	}
	// 抽象产品B
	interface abstractProductB {
		public function getName();
	}
	// 具体产品Ａ1
	class productA1 implements abstractProductA {
		private $_name;
		public function __construct() {
			$this->_name = 'product A1';
		}
		public function getName() {
			return $this->_name;
		}
	}
	// 具体产品Ａ2
	class productA2 implements abstractProductA {
		private $_name;
		public function __construct() {
			$this->_name = 'product A2';
		}
		public function getName() {
			return $this->_name;
		}
	}
	// 具体产品B1
	class productB1 implements abstractProductB {
		private $_name;
		public function __construct() {
			$this->_name = 'product B1';
		}
		public function getName() {
			return $this->_name;
		}
	}
	 
	// 具体产品B2
	class productB2 implements abstractProductB {
		private $_name;
		public function __construct() {
			$this->_name = 'product B2';
		}
		public function getName() {
			return $this->_name;
		}
	}
	// 客户端代码
	class Client {
		public static function main() {
			self::run(new concreteFactory1());
			self::run(new concreteFactory2());
		}
		// 调用工厂实例生成产品，输出产品名
		public static function run(abstractFactory $factory) {
			$productA = $factory->createProductA();
			$productB = $factory->createProductB();
			echo $productA->getName(), "\n";
			echo $productB->getName(), "\n";
		}
	}
	Client::main();
?>
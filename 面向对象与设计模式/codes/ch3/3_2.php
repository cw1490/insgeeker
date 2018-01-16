<?php
	// 简单工厂
	class operation {
		protected  $num1 = 0;
		protected  $num2 = 0;

		public function setNum1($num1) {
			$this->num1 = $num1;
		}

		public function setNum2($num2) {
			$this->num2 = $num2;
		}

		public function getResult() {
			$result = 0;
			return $result;
		}
	}

	class operationAdd extends Operation {
		public function getResult() {
			return $this->num1 + $this->num2;
		}
	}

	class operationMul extends Operation {
		public function getResult() {
			return $this->num1 * $this->num2;
		}
	}

	class operationSub extends Operation {
		public function getResult() {
			return $this->num1 - $this->num2;
		}
	}

	class operationDiv extends Operation {
		public function getResult() {
			return $this->num1 / $this->num2;
		}
	}

	class operationFactory {
		public static function createOperation($operation) {
			switch ($operation) {
				case '+':
					$oper = new operationAdd();
					break;
				case '-':
					$oper = new operationSub();
					break;
				case '/':
					$oper = new operationDiv();
					break;
				case '*':
					$oper = new operationMul();
					break;
			}
			return $oper;
		}
	}
	// 客户端代码
	$operation = operationFactory::createOperation('+');
	$operation->setNum1(1);
	$operation->setNum2(2);
	echo $operation->getResult()."\n";
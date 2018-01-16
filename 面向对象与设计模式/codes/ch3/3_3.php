<?php
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

// 定义接口
interface IFactory {
    public function createOperation();
}

class addFactory implements IFactory {
    public function createOperation() {
        return new operationAdd();
    }
}

class subFactory implements IFactory {
    public function createOperation() {
        return new operationSub();
    }
}

class mulFactory implements IFactory {
    public function createOperation() {
        return new operationMul();
    }
}

class divFactory implements IFactory {
    public function createOperation() {
        return new operationDiv();
    }
}

//客户端代码
$operationFactory = new AddFactory();
$operation = $operationFactory->createOperation();
$operation->setNum1(10);
$operation->setNum2(10);
echo $operation->getResult()."\n";
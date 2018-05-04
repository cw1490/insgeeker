<?php
/**
* 抽象原型角色
*/
interface Prototype
{
    public function copy();
}

/**
 * 具体原型角色
 */
class ConcretePrototype implements Prototype
{

    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function copy()
    {
        /* 深拷贝实现
        $serialize_obj = serialize($this); // 序列化
        $clone_obj = unserialize($serialize_obj); // 反序列化       
        return $clone_obj;
        */

        return clone $this; // 浅拷贝
    }
}

/**
 * 测试深拷贝用的引用类
 */
class Demo
{
    public $array;
}

class Client
{

    /**
     * Main program.
     */
    public static function main()
    {

        $demo = new Demo();
        $demo->array = [1, 2];
        $object1 = new ConcretePrototype($demo);
        $object2 = $object1->copy();

        var_dump($object1->getName());
        echo '<br />';
        var_dump($object2->getName());
        echo '<br />';

        $demo->array = [3, 4];
        var_dump($object1->getName());
        echo '<br />';
        var_dump($object2->getName());
        echo '<br />';

    }

}

Client::main();
<?php

/*
单例设计模式 (单态)
定义: 一个类 只能允许有 一个对象存在.
1.不让进: 使类不能被实例化
2.留后门: 设置静态方法
3.给对象: 在静态方法里实例化该类
4.判初夜: 判断是否是 第一次产生该类的对象
5.设静态: 静态方法里 要使用静态属性
*/

class Singleton
{
    //属性值为对象,默认为null
    private static $obj = null;

    // 设置 一个封装的构造方法
    private function __construct()
    {
        //占位, 我就是不让你NEW我~~~
    }

    //后门
    public static function getInstance()
    {
        echo "啊,我是后门,进吧!\n";
        if (self::$obj === null) {
            self::$obj = new self();//实例化一个对象
        }

        //返回的属性 其实就是本对象
        return self::$obj;
    }
}

/*
Singleton::getInstance();//使用静态方法访问该类里的方法
exit;
*/

$s1 = Singleton::getInstance();
$s2 = Singleton::getInstance();
$s3 = Singleton::getInstance();
$s4 = Singleton::getInstance();
$s5 = Singleton::getInstance();
$s6 = Singleton::getInstance();
$s7 = Singleton::getInstance();
$s8 = Singleton::getInstance();

//判断 两个对象 是否是同一个对象
if ($s1 === $s6) {
    echo "哦, Yes! 是同一个实例\n";
} else {
    echo "哦, No! 不是同一个实例\n";
}
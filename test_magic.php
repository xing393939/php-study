<?php

class a
{
    public $var2;
    public $var3;

    function __construct()
    { // 实例化类时自动调用。
        var_dump(__METHOD__);
    }

    function __destruct()
    { // 类对象使用结束时自动调用。
        var_dump(__METHOD__);
    }

    function __set($a, $b)
    { // 在给未定义的属性赋值的时候调用。
        var_dump(__METHOD__, $a, $b);
    }

    function __get($a)
    { // 调用未定义的属性时候调用。
        var_dump(__METHOD__);
    }

    function __isset($a)
    { // 使用isset() { //或empty() { //函数时候会调用。
        var_dump(__METHOD__);
    }

    function __unset($a)
    { // 使用unset() { //时候会调用。
        var_dump(__METHOD__);
    }

    function __sleep()
    { // 使用serialize序列化时候调用。
        var_dump(__METHOD__);
        return ["var2"];
    }

    function __wakeup()
    { // 使用unserialize反序列化的时候调用。
        var_dump(__METHOD__);
    }

    function __call($a, $b)
    { // 调用一个不存在的方法的时候调用。
        var_dump(__METHOD__, $a, $b);
    }

    static function __callStatic($a, $b)
    { //调用一个不存在的静态方法是调用。
        var_dump(__METHOD__, $a, $b);
    }

    function __toString()
    { // 把对象转换成字符串的时候会调用。比如 echo。
        var_dump(__METHOD__);
        return "";
    }

    function __invoke()
    { // 当尝试把对象当方法调用时调用。
        var_dump(__METHOD__);
    }

    function __set_state()
    { // 当使用var_export() { //函数时候调用。接受一个数组参数。
        var_dump(__METHOD__);
    }

    function __clone()
    { // 当使用clone复制一个对象时候调用。
        var_dump(__METHOD__);
    }
}
echo "<pre>";
$b = new a();
$b->foo();
$b->var = "var";
$b->var2 = "var2";
$b->var3;
$c = clone($b);
var_export($b);
(string) $b;
$b();
$c = serialize($b);
$c = unserialize($c);
var_dump($c);
unset($b);
a::bar();

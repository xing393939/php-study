<?php
class farther1 {
    static public $s1 = "1";
    function f1() {
        var_dump(static::f4());
    }
    function f4() {

    }
    static function f3() {

    }
}

class test extends farther1 {
    static public $s1 = "s1";

    function f2() {
        var_dump(self::$s1);
    }
}

$t = new test();
$t->f1();

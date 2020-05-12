<?php
# example 1
$funcArr = [];
for ($i = 1; $i < 5; $i++) {
    $funcArr[$i] = function () use ($i) {
        $i *= 100;
        var_dump($i);
    };
}
foreach ($funcArr as $func) {
    $func();
}

#example 2
class A
{
    public static $sta = 4;

    function __construct($val)
    {
        $this->val = $val;
    }

    function getClosure()
    {
        return function () {
            if (!isset($this)) {
                return A::$sta;
            } else {
                return $this->val;
            }
        };
    }
}

$ob1 = new A(1);
$ob2 = new A(2);
$cl = $ob1->getClosure();
echo $cl(), "\n";
$cl = $cl->bindTo($ob2);
echo $cl(), "\n";
$cl = Closure::bind($cl, new A(3));
echo $cl(), "\n";
$cl = Closure::bind($cl, null, new A(0));
echo $cl(), "\n";

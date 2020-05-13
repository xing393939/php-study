<?php

class middleware1
{
    static function handle($next)
    {
        var_dump("middleware 1");
        $next();
        var_dump("middleware 1");
    }
}

class middleware2
{
    static function handle($next)
    {
        var_dump("middleware 2");
        $next();
        var_dump("middleware 2");
    }
}

$carry = function ($next, $className) {
    return function () use ($next, $className) {
        return $className::handle($next);
    };
};
$prepare = function () {
    var_dump("prepare slice");
};
$pipeline = array_reduce(
    array_reverse(["middleware1", "middleware2"]), $carry, $prepare
);
$pipeline();
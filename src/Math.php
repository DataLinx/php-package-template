<?php

namespace DataLinx\PhpPackageTemplate;

class Math
{
    public static function add($a, $b)
    {
        return $a + $b;
    }

    public static function subtract($a, $b)
    {
        return $a - $b;
    }

    public static function multiply($a, $b)
    {
        return $a * $b;
    }

    public static function divide($a, $b): float|int
    {
        return $a / $b;
    }
}

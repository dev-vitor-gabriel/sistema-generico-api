<?php

namespace App\Helpers;

class FormatterValue
{
    public static function formatterMoney($value)
    {
        return number_format($value, 2, ',', '.');
    }
}

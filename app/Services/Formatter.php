<?php

namespace App\Services;

trait Formatter
{
    protected function getNumberFormatter(int $fractionDigits): \NumberFormatter
    {
        $formatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::TYPE_INT32);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $fractionDigits);
        return $formatter;
    }
}

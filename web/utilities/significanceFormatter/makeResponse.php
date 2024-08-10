<?php

function makeResponse($data) {
    $numberString = $data['number'];
    $digitsString = $data['digits'];
    $number = filter_var($data['number'], FILTER_VALIDATE_FLOAT);
    $sign = '';
    if ($number < 0) {
        $sign = '-';
        $number = abs($number);
    }
    $prefixesPositive = ['', 'k', 'M', 'G', 'T', 'P', 'E'];
    $prefixesNegative = ['', 'm', 'micro', 'n', 'p', 'f', 'a'];
    $log10Number = log10($number);
    $exponent = floor($log10Number);
    $triple = floor($exponent / 3);
    $prefix = '';
    if ($triple > 0) {
        $triple = min($triple, count($prefixesPositive) - 1);
        $prefix = $prefixesPositive[$triple];
    } elseif ($triple < 0) {
        $triple = max($triple, 1 - count($prefixesNegative));
        $prefix = $prefixesNegative[$triple];
    }
    $mantissa = $number / pow(10, 3 * $triple);
    $digits = filter_var($data['digits'], FILTER_VALIDATE_INT);
    $mantissa = round($mantissa, $digits - $exponent);
    $outputString = $sign . strval($mantissa) . $prefix;
    return ['formattedNumber' => $outputString];
}

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
    // uncomment following two lines after completion of testing
    $prefixesPositive = ['', 'k']; //'k', 'M', 'G', 'T', 'P', 'E'];
    $prefixesNegative = ['', 'm']; //, 'micro', 'n', 'p', 'f', 'a'];
    $log10Number = log10($number);
    $digits = filter_var($data['digits'], FILTER_VALIDATE_INT);
    $offset = $digits - 1;
    $exponent = floor($log10Number);
    $mantissa = $number / pow(10, $exponent);
    $decimal_dust = pow(10, -8);
    if (abs(round($mantissa * pow(10, $offset), 0) - pow(10, $offset + 1)) < $decimal_dust) {
        $mantissa /= 10;
        $exponent++;
    }
    $mantissa *= pow(10, $offset);
    $triples = floor($exponent / 3);
    $prefix = '';
    if ($triples > 0) {
        $triple = min($triples, count($prefixesPositive) - 1);
        $prefix = $prefixesPositive[$triples];
    } elseif ($triples < 0) {
        $triple = max($triples, 1 - count($prefixesNegative));
        $prefix = $prefixesNegative[-$triples];
    }
    $fac = pow(10, $exponent - 3 * $triples);
    $mantissa = round($mantissa / $fac, $offset) * $fac;
    $outputString = $sign . strval($mantissa) . $prefix;
    return ['formattedNumber' => $outputString];
}

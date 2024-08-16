<?php

function makeResponse($data) {
    $numberString = $data['number'];
    $digitsString = $data['digits'];
    $numberValidated = filter_var($numberString, FILTER_VALIDATE_FLOAT);
    if (!numberValidated) {
        return ['error' => "{$numberString} param cannot be parsed as a number."];
    }
    $sign = '';
    if ($numberValidated < 0) {
        $sign = '-';
        $numberValidated = abs($numberValidated);
    }
    $prefixesPositive = ['', 'k', 'M', 'G', 'T', 'P', 'E'];
    $prefixesNegative = ['', 'm', 'µ', 'n', 'p', 'f', 'a'];
    $log10Number = log10($numberValidated);
    $digits = filter_var($data['digits'], FILTER_VALIDATE_INT);
    $precision = $digits - 1;
    $exponent = floor($log10Number);
    $mantissa = $numberValidated / pow(10, $exponent);
    $decimal_dust = pow(10, -8);
    // edge case: rounding causes mantissa to shift up to 10.
    if (abs(round($mantissa, $precision) - 10) < $decimal_dust) {
        $mantissa /= 10;
        $exponent++;
    }
    $triples = floor($exponent / 3);
    $prefix = '';
    // Accommodate max/min prefixes.
    if ($triples > 0) {
        $triples = min($triples, count($prefixesPositive) - 1);
        $prefix = $prefixesPositive[$triples];
    } elseif ($triples < 0) {
        $triples = max($triples, 1 - count($prefixesNegative));
        $prefix = $prefixesNegative[-$triples];
    }
    $mantissa = strval(round($mantissa, $precision) * pow(10, $exponent - 3 * $triples));
    $hasDecimalPt = str_contains($mantissa, '.');
    $zerosNeeded = $digits - (strlen($mantissa) - ($hasDecimalPt ? 1 : 0));
    if ($zerosNeeded > 0) {
        $mantissa .= (($hasDecimalPt ? '' : '.') . str_repeat('0', $zerosNeeded));
    }
    return [
        'error' => '',
        'message' => ['sign' => $sign, 'mantissa' => $mantissa, 'prefix' => $prefix],
    ];
}

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
    $digits = filter_var($data['digits'], FILTER_VALIDATE_INT);
    // following is temporary
    $outputString = strval($number);
    $outputString = $sign . $outputString;
    return ['formattedNumber' => $outputString];
}

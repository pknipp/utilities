<?php

function makeHtml($data) {
    $numberString = $data['number'];
    $digitsString = $data['digits'];
    $number = filter_var($data['number'], FILTER_VALIDATE_FLOAT);
    $digits = filter_var($data['digits'], FILTER_VALIDATE_INT);
    // Following is only temporary.
    $outputString = $number + $digits;
    return ['formattedNumber' => $outputString];
}

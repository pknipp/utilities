<?php

function significanceFormatter($numberString, $digitsString) {
    $number = filter_var($numberString, FILTER_VALIDATE_FLOAT);
    $digits = filter_var($digitsString, FILTER_VALIDATE_INT);
    // Following is only temporary.
    $outputString = $number + $digits;
    return ['formattedNumber' => $outputString];
}

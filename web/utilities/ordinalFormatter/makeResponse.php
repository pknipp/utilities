<?php

function makeResponse($data) {
    $numberString = $data['number'];
    $digitsString = $data['digits'];
    //This ternary seems necessary to catch this corner case.
    $numberValidated = ($numberString == '0' ? 0 : filter_var($numberString, FILTER_VALIDATE_INT));
    if (!($numberValidated || $numberString == '0')) {
        return ['error' => "Param ({$numberString}) cannot be parsed as a number."];
    }
    if ($numberValidated < 0) {
        return [
            'error' => "Paramn ({$numberString}) cannot be negative.",
        ];
    }
    $n100 = $numberValidated % 100;
    $n10 = $numberValidated % 10;
    $number = $numberValidated . ($n10 == 1 ? 'st' : ($n10 == 2 ? 'nd' : ($n10 == 3 ? 'rd' : 'th')));
    if ($n100 == 11 || $n100 == 12 || $n100 == 13) {
        $number = $numberValidated . 'th';
    }
    return [
        'error' => '',
        'message' => ['number' => $number],
    ];
}

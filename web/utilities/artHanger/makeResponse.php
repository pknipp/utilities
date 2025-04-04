<?php

function makeResponse($data) {
    $lengthString = $data['length'];
    $heightString = $data['height'];
    $widthString = $data['width'];
    $studString = $data['stud'];
    $offsetString = $data['offset'];
    //This ternary seems necessary to catch this corner case.
    $lengthValidated = ($lengthString == '0' ? 0 : filter_var($lengthString, FILTER_VALIDATE_INT));
    if (!($lengthValidated || $lengthString == '0')) {
        return ['error' => "Param ({$lengthString}) cannot be parsed as a positive number."];
    }
    if ($lengthValidated < 0) {
        return [
            'error' => "Param ({$lengthString}) cannot be negative.",
        ];
    }
    $heightValidated = ($heightString == '0' ? 0 : filter_var($heightString, FILTER_VALIDATE_INT));
    if (!($heightValidated || $heightString == '0')) {
        return ['error' => "Param ({$heightString}) cannot be parsed as a positive number."];
    }
    if ($heightValidated < 0) {
        return [
            'error' => "Param ({$heightString}) cannot be negative.",
        ];
    }
    $widthValidated = ($widthString == '0' ? 0 : filter_var($widthString, FILTER_VALIDATE_INT));
    if (!($widthValidated || $widthString == '0')) {
        return ['error' => "Param ({$widthString}) cannot be parsed as a positive number."];
    }
    if ($widthValidated < 0) {
        return [
            'error' => "Param ({$widthString}) cannot be negative.",
        ];
    }
    $studValidated = ($studString == '0' ? 0 : filter_var($studString, FILTER_VALIDATE_INT));
    if (!($studValidated || $studString == '0')) {
        return ['error' => "Param ({$studString}) cannot be parsed as a positive number."];
    }
    if ($studValidated < 0) {
        return [
            'error' => "Param ({$studString}) cannot be negative.",
        ];
    }
    $offsetValidated = ($offsetString == '0' ? 0 : filter_var($offsetString, FILTER_VALIDATE_INT));
    if (!($offsetValidated || $offsetString == '0')) {
        return ['error' => "Param ({$offsetString}) cannot be parsed as a positive number."];
    }
    if ($offsetValidated < 0) {
        return [
            'error' => "Param ({$offsetString}) cannot be negative.",
        ];
    }

    return [
        'error' => '',
        'message' => ['length' => $lengthValidated],
    ];
}

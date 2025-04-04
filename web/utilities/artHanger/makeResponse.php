<?php

function makeResponse($data) {
    $lengthString = $data['length'];
    $heightString = $data['height'];
    $widthString = $data['width'];
    $studString = $data['stud'];
    $offsetString = $data['offset'];
    //This ternary seems necessary to catch this corner case.
    $lengthValidated = ($lengthString == '0' ? 0 : filter_var($lengthString, FILTER_VALIDATE_FLOAT));
    if (!($lengthValidated || $lengthString == '0')) {
        return ['error' => "Param ({$lengthString}) cannot be parsed as a positive number."];
    }
    if ($lengthValidated < 0) {
        return [
            'error' => "Param ({$lengthString}) cannot be negative.",
        ];
    }
    $heightValidated = ($heightString == '0' ? 0 : filter_var($heightString, FILTER_VALIDATE_FLOAT));
    if (!($heightValidated || $heightString == '0')) {
        return ['error' => "Param ({$heightString}) cannot be parsed as a positive number."];
    }
    if ($heightValidated < 0) {
        return [
            'error' => "Param ({$heightString}) cannot be negative.",
        ];
    }
    $widthValidated = ($widthString == '0' ? 0 : filter_var($widthString, FILTER_VALIDATE_FLOAT));
    if (!($widthValidated || $widthString == '0')) {
        return ['error' => "Param ({$widthString}) cannot be parsed as a positive number."];
    }
    if ($widthValidated < 0) {
        return [
            'error' => "Param ({$widthString}) cannot be negative.",
        ];
    }
    $studValidated = ($studString == '0' ? 0 : filter_var($studString, FILTER_VALIDATE_FLOAT));
    if (!($studValidated || $studString == '0')) {
        return ['error' => "Param ({$studString}) cannot be parsed as a positive number."];
    }
    if ($studValidated < 0) {
        return [
            'error' => "Param ({$studString}) cannot be negative.",
        ];
    }
    $offsetValidated = ($offsetString == '0' ? 0 : filter_var($offsetString, FILTER_VALIDATE_FLOAT));
    if (!($offsetValidated || $offsetString == '0')) {
        return ['error' => "Param ({$offsetString}) cannot be parsed as a positive number."];
    }
    if ($offsetValidated < 0) {
        return [
            'error' => "Param ({$offsetString}) cannot be negative.",
        ];
    }
    $xLeft = $widthValidated / 2 - $offsetValidated;
    $xMiddle = $studValidated;
    $xRight = $widthValidated / 2 + $offsetValidated - $studValidated;
    $a = $xLeft ** 2;
    $b = (1 - $xRight / $xLeft) ** 2;
    $c = $xMiddle ** 2;
    $d = ($xRight / $xLeft) ** 2;
    $e = $xLeft ** 2;
    $urlFrag = "/" . $heightValidated . "/sqrt(y2+" . $a . ")+sqrt(" . $b . "y2+" . $c . ")+sqrt(" . $d . "y2+" . $e . ")-" . $lengthValidated;
    echo $urlFrag;

    $url = 'https://basic-calculus.herokuapp.com/api/root-finding' . $urlFrag;

    echo $url;

    $response = @file_get_contents($url);

    if ($response === FALSE) {
        echo "Error fetching data.";
    } else {
        // Process the response
        echo $response; // Simple output
        // or, for JSON responses
        $data = json_decode($response, true);
        if($data === null && json_last_error() !== JSON_ERROR_NONE){
            echo "json decode error: " . json_last_error_msg();
        } else {
            print_r($data);
        }
    }

    return [
        'error' => '',
        'message' => ['data' => $data],
    ];
}

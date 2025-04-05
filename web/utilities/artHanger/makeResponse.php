<?php

function makeResponse($data) {
    $lengthString = $data['length'];
    $heightString = $data['height'];
    $widthString = $data['width'];
    $studString = $data['stud'];
    $offsetString = $data['offset'];
    //This ternary seems necessary to catch this corner case.
    $length = ($lengthString == '0' ? 0 : filter_var($lengthString, FILTER_VALIDATE_FLOAT));
    if (!($length || $lengthString == '0')) {
        return ['error' => "Param ({$lengthString}) cannot be parsed as a positive number."];
    }
    if ($length < 0) {
        return [
            'error' => "Param ({$lengthString}) cannot be negative.",
        ];
    }
    $height = ($heightString == '0' ? 0 : filter_var($heightString, FILTER_VALIDATE_FLOAT));
    if (!($height || $heightString == '0')) {
        return ['error' => "Param ({$heightString}) cannot be parsed as a positive number."];
    }
    if ($height < 0) {
        return [
            'error' => "Param ({$heightString}) cannot be negative.",
        ];
    }
    $width = ($widthString == '0' ? 0 : filter_var($widthString, FILTER_VALIDATE_FLOAT));
    if (!($width || $widthString == '0')) {
        return ['error' => "Param ({$widthString}) cannot be parsed as a positive number."];
    }
    if ($width < 0) {
        return [
            'error' => "Param ({$widthString}) cannot be negative.",
        ];
    }
    $stud = ($studString == '0' ? 0 : filter_var($studString, FILTER_VALIDATE_FLOAT));
    if (!($stud || $studString == '0')) {
        return ['error' => "Param ({$studString}) cannot be parsed as a positive number."];
    }
    if ($stud < 0) {
        return [
            'error' => "Param ({$studString}) cannot be negative.",
        ];
    }
    $offset = ($offsetString == '0' ? 0 : filter_var($offsetString, FILTER_VALIDATE_FLOAT));
    if (!($offset || $offsetString == '0')) {
        return ['error' => "Param ({$offsetString}) cannot be parsed as a positive number."];
    }
    if ($offset < 0) {
        return [
            'error' => "Param ({$offsetString}) cannot be negative.",
        ];
    }
    $xLeft = $width / 2 - $offset;
    $xMiddle = $stud;
    $xRight = $width / 2 + $offset - $stud;
    $a = $xLeft ** 2;
    $b = (1 - $xRight / $xLeft) ** 2;
    $c = $xMiddle ** 2;
    $d = ($xRight / $xLeft) ** 2;
    $e = $xRight ** 2;
    $urlFrag = "/" . $height ** 2 . "/sqrt(x+" . $a . ")+sqrt(" . $b . "x+" . $c . ")+sqrt(" . $d . "x+" . $e . ")-" . $length;

    $url = 'https://basic-calculus.herokuapp.com/api/root-finding' . $urlFrag;

    $response = @file_get_contents($url);

    if ($response === FALSE) {
        echo "Error fetching data.";
    } else {
        $data = json_decode($response, true);
        if($data === null && json_last_error() !== JSON_ERROR_NONE){
            echo "json decode error: " . json_last_error_msg();
        }
        $y1 = sqrt($data['x']);
        $y2 = $xRight * $y1 / $xLeft;
        $widthPx = 1400;
        $scale = $widthPx / $width;
        $slope = $y1 / ($W / 2 - $offset);
        $triangleHeight = $slope * $W / 2;
        $heightPx = $scale * max($triangleHeight, $height);

        return [
            'error' => '',
            'message' => [
                'y1' => $y1,
                'y2' => $y2,
                'length' => $length,
                'height' => $height,
                'width' => $width,
                'stud' => $stud,
                'offset' => $offset,
                'scale' => $scale,
                'widthPx' => $widthPx,
                'heightPx' => $heightPx,
            ],
        ];
    }
}

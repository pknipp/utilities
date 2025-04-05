<?php

function makeResponse($data) {
    $offsetString = $data['offset'];
    $studString = $data['stud'];
    $widthString = $data['width'];
    $lengthString = $data['length'];
    $heightString = $data['height'];

    //This ternary seems necessary to catch this corner case.
    $offset = ($offsetString == '0' ? 0 : filter_var($offsetString, FILTER_VALIDATE_FLOAT));
    if (!($offset || $offsetString == '0')) {
        return ['error' => "Your offset O ({$offsetString}) cannot be parsed as a positive number."];
    }
    if ($offset < 0) {
        return [
            'error' => "Your offset O ({$offsetString}) cannot be negative.",
        ];
    }

    $stud = ($studString == '0' ? 0 : filter_var($studString, FILTER_VALIDATE_FLOAT));
    if (!($stud || $studString == '0')) {
        return [
            'error' => "Your stud-spacing ({$studString}) cannot be parsed as a positive number.",
        ];
    }
    if ($stud < 0) {
        return [
            'error' => "Your stud-spacing ({$studString}) cannot be negative.",
        ];
    }

    if ($offset > $stud) {
        return [
            'error' => "Your offset O ({$offsetString}) cannot exceed your stud-spacing S ({$studString}).",
        ];
    }

    $complement = $stud - $offset;
    if ($offset > $stud / 2) {
        return ['error' => "Change your O value ({$offsetString}) to {$complement}.
            From symmetry the results should be the same, and this seems to make the program happier.",
        ];
    }

    $width = ($widthString == '0' ? 0 : filter_var($widthString, FILTER_VALIDATE_FLOAT));
    if (!($width || $widthString == '0')) {
        return ['error' => "Your width W ({$widthString}) cannot be parsed as a positive number."];
    }
    if ($width < 0) {
        return [
            'error' => "Your width W ({$widthString}) cannot be negative.",
        ];
    }

    if ($stud > $width) {
        return [
            'error' => "Your stud-spacing S  ({$studString}) cannot exceed your width W ({$widthString}).",
        ];
    }

    $length = ($lengthString == '0' ? 0 : filter_var($lengthString, FILTER_VALIDATE_FLOAT));
    if (!($length || $lengthString == '0')) {
        return ['error' => "Your length L ({$lengthString}) cannot be parsed as a positive number."];
    }
    if ($length < 0) {
        return [
            'error' => "Your length ({$lengthString}) cannot be negative.",
        ];
    }

    if ($width > $length) {
        return [
            'error' => "Your width W ({$widthString}) cannot exceed your length L ({$lengthString}).",
        ];
    }
    $lengthMax = abs($width / 2 - $offset) + $stud + abs($width / 2 + $offset - $stud);

    if ($length > $lengthMax) {
        return [
            'error' => "Your length L ({$length}) cannot exceed {$lengthMax}, a quantity based on your specifications for O, S, and W.",
        ];
    }

    $height = ($heightString == '0' ? 0 : filter_var($heightString, FILTER_VALIDATE_FLOAT));
    if (!($height || $heightString == '0')) {
        return ['error' => "Your height ({$heightString}) cannot be parsed as a positive number."];
    }
    if ($height < 0) {
        return [
            'error' => "Your height ({$heightString}) cannot be negative.",
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
    $urlFrag = "/" . 0 . "/sqrt(x+" . $a . ")+sqrt(" . $b . "x+" . $c . ")+sqrt(" . $d . "x+" . $e . ")-" . $length;

    $url = 'https://basic-calculus.herokuapp.com/api/root-finding' . $urlFrag;

    $response = @file_get_contents($url);

    if ($response === FALSE) {
        echo "Error fetching data.";
    } else {
        $data = json_decode($response, true);
        if($data === null && json_last_error() !== JSON_ERROR_NONE){
            echo "json decode error: " . json_last_error_msg();
        }
        error_log(print_r($data, true));
        $ySq = $data['x'];
        $LLeft = sqrt($ySq + $a);
        $LRight = sqrt($d * $ySq + $e);
        $LMid = sqrt($b * $ySq + $c);

        $y1 = sqrt($data['x']);
        $y2 = $xRight * $y1 / $xLeft;

        $tension = $LLeft * $LRight / ($y1 * $LRight + $y2 * $LLeft);
        $t1x = $tension * (-$xLeft / $LLeft + $stud / $LMid);
        $t1y = $tension * ($y1 / $LLeft + ($y1 - $y2) / $LMid);
        $t1 = sqrt($t1x * $t1x + $t1y * $t1y);
        $t2x = $tension * ($xRight / $LRight - $stud / $LMid);
        $t2y = $tension * ($y2 / $LRight + ($y2 - $y1) / $LMid);
        $t2 = sqrt($t2x * $t2x + $t2y * $t2y);

        $widthPx = 1000;
        $scale = $widthPx / $width;
        $slope = $y1 / ($width / 2 - $offset);

        error_log(print_r($y2 / $slope, true));
        $triangleHeight = $slope * $width / 2;
        $heightPx = $scale * max($triangleHeight, $height);

        return [
            'error' => '',
            'message' => [
                // inputs
                'offset' => $offset,
                'stud' => $stud,
                'width' => $width,
                'length' => $length,
                'height' => $height,
                // two most important outputs
                'y1' => $y1,
                'y2' => $y2,
                // useful for graphing
                'scale' => $scale,
                'widthPx' => $widthPx,
                'heightPx' => $heightPx,
                'slope' => $slope,
                // css choices
                'studWidth' => 30,
                'wireWidth' => 4,
                'screwRadius' => 10,
                'tension' => $tension,
                't1' => $t1,
                't2' => $t2,
            ],
        ];
    }
}

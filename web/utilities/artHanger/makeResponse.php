<?php

function makeResponse($data) {
    $version = $data['version'];
    $offsetString = $data['offset'];
    $studString = $data['stud'];
    $widthString = $data['width'];
    $lengthString = $data['length'];
    $heightString = $data['height'];

    if ($version != 'web' && $version != 'mobile') {
        return [
            'error' => "Your specified version ({$version}) is not one of our presently allowable ones ('web' and 'mobile').",
        ];
    }

    //This ternary seems necessary to catch this corner case.
    $offset = ($offsetString == '0' ? 0 : filter_var($offsetString, FILTER_VALIDATE_FLOAT));
    if (!($offset || $offsetString == '0')) {
        return [
            'error' => "Your offset O ({$offsetString}) cannot be parsed as a nonzero number.",
        ];
    }
    if ($offset < 0) $offset = abs($offset);

    $stud = ($studString == '0' ? 0 : filter_var($studString, FILTER_VALIDATE_FLOAT));
    if (!($stud || $studString == '0')) {
        return [
            'error' => "Your stud-spacing ({$studString}) cannot be parsed as a nonzero number.",
        ];
    }
    if ($stud < 0) $stud = abs($stud);
    if ($offset >= $stud) $offset -= floor($offset / $stud);

    $width = ($widthString == '0' ? 0 : filter_var($widthString, FILTER_VALIDATE_FLOAT));
    if (!($width || $widthString == '0')) {
        return [
            'error' => "Your width W ({$widthString}) cannot be parsed as a positive number.",
        ];
    }
    if ($width < 0) $width = abs($width);

    $halfWidth = $width / 2;
    if ($halfWidth <= $offset) {
        return [
            'error' => "Your width W ({$width}) is too small.  The half-width ({$halfWidth}) must exceed the distance ({$offset}) from the artwork's center of gravity to the left stud.",
        ];
    }

    $otherDistance = $stud - $offset;
    if ($halfWidth <= $otherDistance) {
        return [
            'error' => "Your width W ({$width}) is too small.  The half-width ({$halfWidth}) must exceed the distance ({$otherDistance}) from the artwork's center of gravity to the right stud.",
        ];
    }

    $length = ($lengthString == '0' ? 0 : filter_var($lengthString, FILTER_VALIDATE_FLOAT));
    if (!($length || $lengthString == '0')) {
        return ['error' => "Your length L ({$lengthString}) cannot be parsed as a positive number."];
    }
    if ($length < 0) $length = abs($length);
    if ($width >= $length) {
        return [
            'error' => "Your wire length L ({$lengthString}) must exceed your artwork's length W ({$widthString}).",
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
        $ySq = $data['x'];
        $LLeft = sqrt($ySq + $a);
        $LRight = sqrt($d * $ySq + $e);
        $LMid = sqrt($b * $ySq + $c);

        $y1 = sqrt($data['x']);
        $y2 = $xRight * $y1 / $xLeft;

        // The following return info about wire tensions and forces on screws, expressed relative to artwork's weight.
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
                // The following may be used to take ratios of forces.
                'tension' => $tension,
                't1' => $t1,
                't2' => $t2,
            ],
        ];
    }
}

<?php

function makeResponse($data) {
    $widthString = $data['width'];
    $width = filter_var($widthString, FILTER_VALIDATE_FLOAT);
    if (!$width) {
        return ['error' => "1st param ({$widthString}) cannot be parsed as a number."];
    }
    if ($width <= 0) {
        return ['error' => "Width ({$width}) is not a positive number."];
    }
    $xMinString = $data['xMin'];
    $xMin = filter_var($xMinString, FILTER_VALIDATE_FLOAT);
    if (!$xMin) {
        return ['error' => "2nd param ({$xMinString}) cannot be parsed as a number."];
    }
    $xMaxString = $data['xMax'];
    $xMax = filter_var($xMaxString, FILTER_VALIDATE_FLOAT);
    if (!$xMax) {
        return ['error' => "3rd param ({$xMaxString}) cannot be parsed as a number"];
    }
    if ($xMax <= $xMin) {
        return ['error' => "xMax ({$xMax}) is not greater than xMin ({$xMin})."];
    }

    $heightString = $data['height'];
    $height = filter_var($heightString, FILTER_VALIDATE_FLOAT);
    if (!$height) {
        return ['error' => "5th param ({$heightString}) cannot be parsed as a number."];
    }
    if ($height <= 0) {
        return ['error' => "Height ({$height}) is not a positive number."];
    }
    $yMinString = $data['yMin'];
    $yMin = filter_var($yMinString, FILTER_VALIDATE_FLOAT);
    if (!$yMin) {
        return ['error' => "6th param ({$yMinString}) cannot be parsed as a number."];
    }
    $yMaxString = $data['yMax'];
    $yMax = filter_var($yMaxString, FILTER_VALIDATE_FLOAT);
    if (!$yMax) {
        return ['error' => "7th param ({$yMaxString}) cannot be parsed as a number"];
    }
    if ($yMax <= $yMin) {
        return ['error' => "yMax ({$yMax}) is not greater than yMin ({$yMin})."];
    }

    $outputX = tickNumbers($xMin, $xMax);
    $outputY = tickNumbers($yMin, $yMax);
    return [
        'error' => '',
        'message' => [
            'width' => $width,
            'xLabel' => $data['xLabel'],
            'dX' => $outputX['del'],
            'xMin' => $outputX['min'],
            'nX' => $outputX['n'],
            'height' => $height,
            'yLabel' => $data['yLabel'],
            'dY' => $outputX['del'],
            'yMin' => $outputX['min'],
            'nY' => $outputX['n'],
        ],
    ];
}

function tickNumbers($min, $max) {
    // The following is utilized by storybook.
    $nMax = 14.14;
    $del = ($max - $min) / $nMax;
    $pow = 10 ** floor(log10($del));
    $del /= $pow;
    if ($del > 5) {
        $del = 10;
    // The following is used on some scales.
    // } elseif ($del > 2.5) {
        // $del = 5;
    } elseif ($del > 2) {
        $del = 5;
    } else {
        $del = 2;
    }
    $del *= $pow;
    $nMax = ceil($max / $del);
    $nMin = floor($min / $del);
    return [
        'del' => $del,
        'min' => $nMin * $del,
        'n' => $nMax - $nMin,
    ];
}

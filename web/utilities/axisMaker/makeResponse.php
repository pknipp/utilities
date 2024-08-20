<?php

function makeResponse($data) {
    // $xOrY = $data['xOrY'];
    // $isY;
    // if ($xOrY == 'x') {
        // $isY = false;
    // } elseif ($xOrY == 'y') {
        // $isY = true;
    // } else {
        // return ['error' => "First param ({$xOrY}) equals neither 'x' nor 'y'."];
    // }
    $sizeString = $data['size'];
    $size = filter_var(sizeString, FILTER_VALIDATE_FLOAT);
    if (!$size) {
        return ['error' => "Second param ({$sizeString}) cannot be parsed as a number."];
    }
    if ($size <= 0) {
        return ['error' => "Size ({$size}) is not a positive number."];
    }
    $minString = $data['min'];
    $min = filter_var($minString, FILTER_VALIDATE_FLOAT);
    if (!$min) {
        return ['error' => "Third param ({$minString}) cannot be parsed as a number."];
    }
    $maxString = $data['max'];
    $max = filter_var($maxString, FILTER_VALIDATE_FLOAT);
    if (!$max) {
        return ['error' => "Fourth param ({$maxString}) cannot be parsed as a number"];
    }
    if ($max <= $min) {
        return ['error' => "Max ({$max}) is not greater than min ({$min})."];
    }
    return [
        'error' => '',
        'message' => tickNumbers($min, $max),
    ];
}

function tickNumbers($min, $max) {
    // The following is utilized by storybook.
    $nMax = 14.14;
    $dx = ($max - $min) / $nMax;
    $pow = 10 ** floor(log10($dx));
    $dx /= $pow;
    if ($dx > 5) {
        $dx = 10;
    // The following is used on some scales.
    // } elseif ($dx > 2.5) {
        // $dx = 5;
    } elseif ($dx > 2) {
        $dx = 5;
    } else {
        $dx = 2;
    }
    $dx *= $pow;
    $nMax = ceil($xMax / $dx);
    $nMin = floor($xMin / $dx);
    return [
        'dx' => $dx,
        'xMin' => $nMin * $dx,
        'xMax' => $nMax * $dx,
    ];
}

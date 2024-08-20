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
    $size = filter_var($sizeString, FILTER_VALIDATE_FLOAT);
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
    $output = tickNumbers($min, $max);
    return [
        'error' => '',
        'message' => [
            'size' => $size,
            'del' => $output['del'],
            'min' => $output['min'],
            'n' => $output['n'],
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

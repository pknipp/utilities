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
    $output = tickNumbers($xMin, $xMax);
    $returnMe = [
        'error' => '',
        'message' => [
            'width' => $width,
            'dX' => $output['del'],
            'xMin' => $output['min'],
            'nX' => $output['n'],
        ],
    ];
    $returnMe['message']['height'] = 600;
    return $returnMe;
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

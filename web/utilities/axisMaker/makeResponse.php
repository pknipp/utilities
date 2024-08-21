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

    $heightString = $data['height'];
    $height = filter_var($heightString, FILTER_VALIDATE_FLOAT);
    if (!$height) {
        return ['error' => "3rd param ({$heightString}) cannot be parsed as a number."];
    }
    if ($height <= 0) {
        return ['error' => "Height ({$height}) is not a positive number."];
    }

    $xys = parseXys($data['xys'], INF, -INF, INF, -INF);
    $outputX = tickNumbers($xys['xMin'], $xys['xMax']);
    $outputY = tickNumbers($xys['yMin'], $xys['yMax']);

    $xys = (empty($xys['error'])) ? $xys['xys'] : [];
    return [
        'error' => $xys['error'],
        'message' => [
            'width' => $width,
            'xLabel' => $data['xLabel'],
            'dX' => $outputX['del'],
            'xMin' => $outputX['min'],
            'nX' => $outputX['n'],
            'height' => $height,
            'yLabel' => $data['yLabel'],
            'dY' => $outputY['del'],
            'yMin' => $outputY['min'],
            'nY' => $outputY['n'],
            'xys' => $xys,
            'mx' => $outputX['m'],
            'bx' => $outputX['b'],
            'my' => $outputY['m'],
            'by' => $outputY['b'],
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
        'm' => 1 / ($nMax - $nMin) / $del,
        'b' => $nMin / ($nMin - $nMax),
    ];
}

function parseXys($xysString, $xMin, $xMax, $yMin, $yMax) {
    $error = '';
    $xysString = preg_replace('/\s+/', '', $xysString);
    if (strlen($xysString) < 2) {
        return ['error' => "Last param ({$xysString}) should have at least two characters."];
    }
    $leftChar = substr($xysString, 0, 1);
    if ($leftChar !== '[') {
        return ['error' => "Leading character of last param should be '[', not {$leftChar}."];
    }
    $xysString = substr($xysString, 1);
    $rightChar = substr($xysString, -1, 1);
    if ($rightChar !== ']') {
        return ['error' => "Trailing character of last param should be ']', not {$rightChar}."];
    }
    $xysString = substr($xysString, 0, -1);
    if (empty($xysString)) {
        return [];
    }
    $leftChar = substr($xysString, 0, 1);
    if ($leftChar !== '(') {
        return ['error' => "The 2nd leading character of the last param should be '(', not {$leftChar}."];
    }
    $xysString = substr($xysString, 1);
    $rightChar = substr($xysString, -1, 1);
    if ($rightChar !== ')') {
        return ['error' => "The penultimate character of the last param should be ')', not {$rightChar}."];
    }
    $xysString = substr($xysString, 0, -1);
    $xyStrings = explode('),(', $xysString);
    $xys = [];
    foreach ($xyStrings as $xyString) {
        $xy = explode(',', $xyString);
        if (count($xy) !== 2) {
            return ['error' => "{$xyString} has {count($xy)} values, not 2."];
        }
        $xString = $xy[0];
        $yString = $xy[1];
        $x = filter_var($xString, FILTER_VALIDATE_FLOAT);
        if ($x === false) {
            return ['error' => "One value ({$xString}) cannot be parsed as a number."];
        }
        $xMin = min($x, $xMin);
        $xMax = max($x, $xMax);
        $y = filter_var($yString, FILTER_VALIDATE_FLOAT);
        if ($y === false) {
            return ['error' => "One value ({$yString}) cannot be parsed as a number."];
        }
        $yMin = min($y, $yMin);
        $yMax = max($y, $yMax);
        array_push($xys, [$x, $y]);
    };
    return [
        'error' => '',
        'xys' => $xys,
        'xMin' => $xMin,
        'xMax' => $xMax,
        'yMin' => $yMin,
        'yMax' => $yMax,
    ];
}

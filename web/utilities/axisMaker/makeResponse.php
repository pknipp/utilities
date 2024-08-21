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
    // $xMinString = $data['xMin'];
    // $xMin = filter_var($xMinString, FILTER_VALIDATE_FLOAT);
    // if (!$xMin) {
        // return ['error' => "2nd param ({$xMinString}) cannot be parsed as a number."];
    // }
    // $xMaxString = $data['xMax'];
    // $xMax = filter_var($xMaxString, FILTER_VALIDATE_FLOAT);
    // if (!$xMax) {
        // return ['error' => "3rd param ({$xMaxString}) cannot be parsed as a number"];
    // }
    // if ($xMax <= $xMin) {
        // return ['error' => "xMax ({$xMax}) is not greater than xMin ({$xMin})."];
    // }

    $heightString = $data['height'];
    $height = filter_var($heightString, FILTER_VALIDATE_FLOAT);
    if (!$height) {
        return ['error' => "5th param ({$heightString}) cannot be parsed as a number."];
    }
    if ($height <= 0) {
        return ['error' => "Height ({$height}) is not a positive number."];
    }
    // $yMinString = $data['yMin'];
    // $yMin = filter_var($yMinString, FILTER_VALIDATE_FLOAT);
    // if (!$yMin) {
        // return ['error' => "6th param ({$yMinString}) cannot be parsed as a number."];
    // }
    // $yMaxString = $data['yMax'];
    // $yMax = filter_var($yMaxString, FILTER_VALIDATE_FLOAT);
    // if (!$yMax) {
        // return ['error' => "7th param ({$yMaxString}) cannot be parsed as a number"];
    // }
    // if ($yMax <= $yMin) {
        // return ['error' => "yMax ({$yMax}) is not greater than yMin ({$yMin})."];
    // }

    $xMin = INF;
    $yMin = INF;
    $xMax = -INF;
    $yMax = -INF;
    $xys = parseXys($data['xYsString'], $xMin, $xMax, $yMin, $yMax);
    $outputX = tickNumbers($xys['xMin'], $xys['xMax']);
    $outputY = tickNumbers($xys['yMin'], $xys['yMax']);

    $xys = (empty($xys['error'])) ? $xys['xys'] : [];
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
            'dY' => $outputY['del'],
            'yMin' => $outputY['min'],
            'nY' => $outputY['n'],
            'xys' => $xys,
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

function parseXys($xYsString, $xMin, $xMax, $yMin, $yMax) {
    $error = '';
    if (strlen($xYsString) < 2) {
        return ['error' => "Last param ({$xYsString}) should have at least two characters."];
    }
    $leftChar = array_shift($xYsString);
    if ($leftChar !== '[') {
        return ['error' => "Leading character of last param should be '[', not {$leftChar}."];
    }
    $rightChar = array_pop($xYsString);
    if ($rightChar !== ']') {
        return ['error' => "Trailing character of last param should be ']', not {$rightChar}."];
    }
    $xYsString = preg_replace('/\s+/', '', $xYsString);
    if (empty($xYsString)) {
        return [];
    }
    $leftChar = substr($xYsString);
    if (leftChar !== '(') {
        return ['error' => "The 2nd leading character of the last param should be '(', not {$leftChar}."];
    }
    $xYsString = substr($xYsString, 1);
    $rightChar = substr($xYsString, -1);
    if (rightChar !== ')') {
        return ['error' => "The penultimate character of the last param should be ')', not {$rightChar}."];
    }
    $xYsString = substr_replace($xYsString, '', -1);
    $leftChar = array_shift($xYsString);
    $xyStrings = explode('),(', $xYsString);
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
        $xys.push([$x, $y]);
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

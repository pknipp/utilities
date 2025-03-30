<?php

function makeResponse($data) {
    $widthString = $data['width'];
    $width = filter_var($widthString, FILTER_VALIDATE_FLOAT);
    if ($width === false) {
        return ['error' => "1st param ({$widthString}) cannot be parsed as a number."];
    }
    if ($width <= 0) {
        return ['error' => "Width ({$width}) is not a positive number."];
    }
    // $showZeroX = $data['showZeroX'];
    // if ($showZeroX === 'true' || $showZeroX === 'True' || $showZeroX === 'TRUE' || $showZeroX === 'T') {
        // $showZeroX = true;
    // } elseif ($showZeroX === 'false' || $showZeroX === 'False' || $showZeroX === 'FALSE' || $showZeroX === 'F') {
        // $showZeroX = false;
    // } else {
        // return ['error' => "{$showZeroX} is not a valid boolean."];
    // }
    $result = parseBool($data['showZeroX']);
    if (!empty($result['error'])) {
        return $result;
    }
    $showZeroX = $result['value'];

    $heightString = $data['height'];
    $height = filter_var($heightString, FILTER_VALIDATE_FLOAT);
    if ($height === false) {
        return ['error' => "3rd param ({$heightString}) cannot be parsed as a number."];
    }
    if ($height <= 0) {
        return ['error' => "Height ({$height}) is not a positive number."];
    }

    $result = parseBool($data['showZeroY']);
    if (!empty($result['error'])) {
        return $result;
    }
    $showZeroY = $result['value'];

    $result = parseBool($data['squareAspectRatio']);
    if (!empty($result['error'])) {
        return $result;
    }
    $squareAspectRatio = $result['value'];

    // $squareAspectRatio = $data['squareAspectRatio'];
    // if ($squareAspectRatio === 'true' || $squareAspectRatio === 'True' || $squareAspectRatio === 'TRUE' || $squareAspectRatio === 'T') {
        // $squareAspectRatio = true;
    // } elseif ($squareAspectRatio === 'false' || $squareAspectRatio === 'False' || $squareAspectRatio === 'FALSE' || $squareAspectRatio === 'F') {
        // $squareAspectRatio = false;
    // } else {
        // return ['error' => "{$squareAspectRatio} is not a valid boolean."];
    // }

    $xys = parseXys($data['xys'], INF, -INF, INF, -INF, $showZeroX, $showZeroY);
    if (!empty($xys['error'])) {
        return ['error' => $xys['error']];
    } else {
        $outputX = tickNumbers($xys['xMin'], $xys['xMax']);
        $outputY = tickNumbers($xys['yMin'], $xys['yMax']);
        return [
            'error' => '',
            'message' => [
                'width' => $width,
                'xLabel' => $data['xLabel'],
                'dX' => $outputX['del'],
                'xMin' => $outputX['min'],
                'nX' => $outputX['n'],
                'height' => ($squareAspectRatio) ? ($outputY['max'] - $outputY['min']) * $width / ($outputX['max'] - $outputX['min']): $height,
                'yLabel' => $data['yLabel'],
                'dY' => $outputY['del'],
                'yMin' => $outputY['min'],
                'nY' => $outputY['n'],
                'xys' => $xys['xys'],
                'lines' => $lines['lines'],
                'mx' => $outputX['m'],
                'bx' => $outputX['b'],
                'my' => $outputY['m'],
                'by' => $outputY['b'],
            ],
        ];
    }
}

function tickNumbers($min, $max) {
    // The following value is utilized by storybook.
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
        'max' => $nMax * $del,
        'n' => $nMax - $nMin,
        'm' => 1 / ($nMax - $nMin) / $del,
        'b' => $nMin / ($nMin - $nMax),
    ];
}

function parseBool($bool) {
    if (in_array($bool, ['true', 'True', 'TRUE', 'T'])) {
        return ['error' => '', 'value' => true];
    } elseif (in_array($bool, [ 'false', 'False', 'FALSE', 'F'])) {
        return ['error' => '', 'value' => false];
    } else {
        return ['error' => "{$bool} is not a valid boolean."];
    }
}

function parseXys($xysString, $xMin, $xMax, $yMin, $yMax, $showZeroX, $showZeroY) {
    $xysString = preg_replace('/\s+/', '', $xysString);
    if (strlen($xysString) < 2) {
        return ['error' => "The 2nd-to-last param ({$xysString}) should have at least two characters."];
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
        return ['error' => 'No data are included.'];
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
    if (count($xyStrings) === 1) {
        return ['error' => 'This cannot set up axes to plot a single point.'];
    }
    $xys = [];
    foreach ($xyStrings as $xyString) {
        $xy = explode(',', $xyString);
        if (count($xy) !== 2 && count($xy) !== 3) {
            return ['error' => $xyString . ' has ' . count($xy) . ' values, not 2 or 3.'];
        }
        $xString = $xy[0];
        $yString = $xy[1];
        $x = filter_var($xString, FILTER_VALIDATE_FLOAT);
        if ($x === false) {
            return ['error' => "One x-value ({$xString}) cannot be parsed as a number."];
        }
        $xMin = min($x, $xMin);
        $xMax = max($x, $xMax);
        $y = filter_var($yString, FILTER_VALIDATE_FLOAT);
        if ($y === false) {
            return ['error' => "One y-value ({$yString}) cannot be parsed as a number."];
        }
        $yMin = min($y, $yMin);
        $yMax = max($y, $yMax);
        array_push($xys, (count($xy) == 2) ? [$x, $y] : [$x, $y, $xy[2]]);
    };
    if ($xMin === $xMax) {
        return ['error' => "This cannot create a horizontal axis for a vertical line."];
    }
    if ($showZeroX && $xMin * $xMax > 0) {
        if ($xMin > 0) {
            $xMin = 0;
        } else {
            $xMax = 0;
        }
    }
    if ($yMin === $yMax) {
        return ['error' => "This cannot create a vertical axis for a horizontal line."];
    }
    if ($showZeroY && $yMin * $yMax > 0) {
        if ($yMin > 0) {
            $yMin = 0;
        } else {
            $yMax = 0;
        }
    }
    return [
        'error' => '',
        'xys' => $xys,
        'xMin' => $xMin,
        'xMax' => $xMax,
        'yMin' => $yMin,
        'yMax' => $yMax,
    ];
}

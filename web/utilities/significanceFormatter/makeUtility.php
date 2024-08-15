<?php

function makeSignificanceFormatterUtility($name) {
    return [
        'name' => $name,
        'pretty' => 'Significance Formatter',
        'description' => "This formats a number with a specified number of <a href='https://en.wikipedia.org/wiki/Significant_figures'>significant digits</a> (aka sigfigs).",
        'background' => 'Roughly speaking, the number of significant digits in a quantity equals its number of nonzero digits.  See <a href="https://en.wikipedia.org/wiki/Significant_figures">Wikipedia</a> for a more precise definition.',
        'instructions' => "Immediately after <tt>{$name}</tt> in the url, type /<number>/<digits>, where <number> is the particular quantity, and <digits> is the number of significant digits with which you want this quantity expressed.",
    ];
}

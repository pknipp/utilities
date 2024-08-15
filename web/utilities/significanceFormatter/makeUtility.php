<?php

function makeSignificanceFormatterUtility($name) {
    return [
        'name' => $name,
        'pretty' => 'Significance Formatter',
        'description' => 'This expresses a specified number with a specified number of <a href="https://en.wikipedia.org/wiki/Significant_figures" target="_blank">significant digits</a> (aka sigfigs), using metric prefixes as necessary.',
        'background' => 'Roughly speaking, the number of significant digits in a quantity equals its number of nonzero digits.  See <a href="https://en.wikipedia.org/wiki/Significant_figures" target="_blank">Wikipedia</a> for a more precise definition.',
        'instructions' => "Immediately after <tt>{$name}</tt> in the url, type <tt>/number/digits</tt>, where <tt>number</tt> is the value of the particular quantity, and <tt>digits</tt> is the number of significant digits with which you want this value expressed.",
    ];
}

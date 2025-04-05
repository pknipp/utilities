<?php

function makeOrdinalFormatter($name) {
    return [
        'name' => $name,
        'pretty' => 'Ordinal Formatter',
        'description' => ' formats a specified integer as an <a href="https://en.wikipedia.org/wiki/Ordinal_numeral" target="_blank">ordinal numeral</a>.',
        'background' => 'This expresses a specified integer as an <a href="https://en.wikipedia.org/wiki/Ordinal_numeral" target="_blank">ordinal numeral</a>.',
        'instructions' => "type <tt>/number</tt>, where <tt>number</tt> is a nonnegative integer.",
        'examples' => 'The results for 1, 12, and 23 are 1st, 12th, and 23rd, respectively.',
    ];
}

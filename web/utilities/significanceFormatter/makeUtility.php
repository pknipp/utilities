<?php

function makeUtility($name) {
    return [
        'name' => $name,
        'pretty' => 'Significance Formatter',
        'description' => 'This formats a number with a specified number of significant digits (aka sigfigs).',
        'background' => 'Talk about sig figs, including link to Wikipedia.',
        'instructions' => '1st item is number, 2nd is # of sig figs',
    ];
}

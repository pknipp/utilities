<?php

function makeAxisMakerUtility($name) {
    return [
        'name' => $name,
        'pretty' => 'Axis Maker',
        'description' => 'This renders an svg of an axis (either horizontal or vertical) for a graph.',
        'background' => 'The main consideration here are that the tickmarks should be round numbers.',
        'instructions' => 'TBD',
        'examples' => 'TBD.  These should be svgs',
    ];
}

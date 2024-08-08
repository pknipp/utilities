<?php

function makeUtilities() {
    $utilities = array();

    $name = 'significanceFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatterUtility($name);

    return $utilities;
    // return ['utilities' => $utilities];
}

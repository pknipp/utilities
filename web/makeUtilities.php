<?php

function makeUtilities() {
    $utilities = array();

    $name = 'significanceFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatterUtility($name);

    $name = 'ordinalFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeOrdinalFormatterUtility($name);

    return $utilities;
}

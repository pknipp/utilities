<?php

function makeUtilities() {
    $utilities = array();

    $name = 'significanceFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatter($name);

    $name = 'ordinalFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeOrdinalFormatter($name);

    $name = 'axisMaker';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeAxisMaker($name);

    return $utilities;
}

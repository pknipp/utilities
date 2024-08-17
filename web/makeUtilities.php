<?php

function makeUtilities() {
    $utilities = array();

    $name = 'significanceFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatterUtility($name);

    $name = 'ordinalFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeOrdinalFormatterUtility($name);

    $name = 'axisMaker';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeAxisMaker($name);

    return $utilities;
}

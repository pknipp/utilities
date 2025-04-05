<?php

function makeUtilities() {
    $utilities = array();

    $name = 'artHanger';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeArtHanger($name);

    $name = 'grapher';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeGrapher($name);

    $name = 'ordinalFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeOrdinalFormatter($name);

    $name = 'significanceFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatter($name);

    return $utilities;
}

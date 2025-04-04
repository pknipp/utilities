<?php

function makeUtilities() {
    $utilities = array();

    $name = 'significanceFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatter($name);

    $name = 'ordinalFormatter';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeOrdinalFormatter($name);

    $name = 'grapher';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeGrapher($name);

    $name = 'artHanger';
    require("./utilities/{$name}/makeUtility.php");
    $utilities[$name] = makeArtHanger($name);

    return $utilities;
}

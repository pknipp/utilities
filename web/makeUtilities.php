<?php

function makeUtilities() {
    $utilities = array();
    require("./utilities/significanceFormatter/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatterUtility($name);
    return ['utilities' => $utilities];
}

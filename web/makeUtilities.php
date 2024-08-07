<?php

function makeUtilities() {
    $utilities = array();
    require("./utilities/significanceFormatter/makeUtility.php");
    $utilities[$name] = makeSignificanceFormatterUtility('significanceFormatter');
    return ['utilities' => $utilities];
}

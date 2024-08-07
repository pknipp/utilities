<?php
// use significanceFormatter\makeUtility as significanceFormatterUtility;

function makeUtilities() {
    $names = [
        'significanceFormatter',
    ];
    $utilities = array();
    foreach ($names as $name) {
        require("./utilities/$name/makeUtility.php");
        $utilities[$name] = makeUtility($name);
    }
    return ['utilities' => $utilities];
}

<?php
// use significanceFormatter\makeUtility as significanceFormatterUtility;
// use App\Web\utilities\significanceFormatter\makeUtility;

function makeUtilities() {
    $names = [
        'significanceFormatter',
    ];
    $utilities = array();
    foreach ($names as $name) {
        // require("./utilities/$name/makeUtility.php");
        $utilities[$name] = "{$name}\makeUtility($name);
    }
    return ['utilities' => $utilities];
}

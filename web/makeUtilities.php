<?php

function makeUtilities() {
    $names = [
        'significanceFormatter',
    ];
    $utilities = array();
    foreach ($names as $name) {
        require("./utilities/$name/makeUtility.php");
        $utilities[$name] = 'makeUtility';
        $utilities[$name] = $utilities[$name]($name);
    }
    return ['utilities' => $utilities];
}

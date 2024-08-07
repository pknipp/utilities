<?php

function makeUtilities() {
    $utilities = array();
    require("./utilities/$name/makeUtility.php");
    $utilities[$name] = makeSFUtility($name);
    return ['utilities' => $utilities];
}

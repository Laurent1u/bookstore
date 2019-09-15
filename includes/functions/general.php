<?php

function tepCheckPath($filePath) {
    if(file_exists($filePath)) {
        return $filePath;
    } else {
        die("tried to call an invalid page");
    }
}

function stringInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = strip_tags($input);

    return $input;
}

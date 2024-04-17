<?php

$spritePaths = [];
function glob_recursive($folder)
{
    global $spritePaths, $recursivity;
    $files = glob("$folder/*");
    foreach ($files as $value) {

        if (is_dir($value)) {
            if ($recursivity) {
                glob_recursive($value);
            }
            echo "un dossier";
        } 
        
        else {

            $path = $value;
            $parts = explode('.', $path);
            $ext = end($parts);
            if ($ext == "png") {
                array_push($spritePaths, $path);
            }
        }
    }

    usort($spritePaths, function ($a, $b) {
        return strlen($a) - strlen($b) ?: strcmp($a, $b);
    });
}

glob_recursive($folder);

<?php

spl_autoload_register(function ($class_name) {
    $directories = ['controllers/', 'models/', 'router/']; 
    foreach ($directories as $directory) {
        $file = $directory.$class_name.".php";
        if (file_exists($file)) {
            include_once($file);
            // return;
        }
    }
});


?>
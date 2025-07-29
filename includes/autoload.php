<?php


spl_autoload_register(function($class) {
    foreach (array("Gregwar", "PIT", "OWASP") as $allowed) {
        if (strpos($class, $allowed) !== 0) {
            continue;
        }
        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $classPath = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        require_once $path . $classPath . ".php";
        return true;
    }
    return false;
});

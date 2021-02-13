<?php

use controller\PageNotFoundController;
use core\log\Log;

include "config\config.php";
include "vendor\autoload.php";

$path = "";
if (php_sapi_name() == 'cli'){
    $path = $argv[1]; // $args[] console-bol meghivott paraméterek
}
else {
    $path = substr(str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['PATH_INFO']), 1); //webes felüleleten paraméter
}

if (class_exists($path)) {
    new $path(); //ide kellene result, hogy lefutot-e, pl. valami log
}
else {
    $fileName = '/system.log';
    $message = date("Y-m-d H:i:s") . PHP_EOL . 'A keresett útvonal nem található: ' . $path;
    new Log($fileName, $message);
//    new PageNotFoundController();
   header("Location: controller\PageNotFoundController"); // itt lehet valami szép oldal (twiggel majd pl) +log
}

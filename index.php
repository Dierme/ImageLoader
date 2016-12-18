<?php

require_once 'vendor/autoload.php';

use imageLoader\Loader;

$url = "http://scheduler/images/logo.png";
$loader = new Loader();
print_r($loader->getimg($url, 'test'));


?>
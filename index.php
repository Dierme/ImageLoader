<?php

require_once 'vendor/autoload.php';
use ImageLoader\Loader;
$url = "http://scheduler/images/logo.png";
$loader = new Loader();
print_r($loader->getimg($url, 'test'));

?>
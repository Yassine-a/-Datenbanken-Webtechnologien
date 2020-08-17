<?php
session_start();
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(__FILE__));

//$url = isset($_SERVER['REQUEST_URI'])? explode('/',ltrim($_SERVER['REQUEST_URI'],'/')):[];
//array_shift($url);
//require_once(ROOT.DS.'core'.DS.'bootstrap.php');


require 'vendor/autoload.php';

// Use-Direktive
Use eftec\bladeone\BladeOne;

$views = 'views';
$cache = 'cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

echo $blade->run('register');

/*

*/
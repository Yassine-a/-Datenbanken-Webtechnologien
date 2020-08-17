<?php

require_once(ROOT.DS.'core'.DS.'config.php');
require_once(ROOT.DS.'core'.DS.'Helpers'.DS.'functions.php');
require_once(ROOT.DS.'core'.DS.'Helpers'.DS.'helpers.php');
require_once(ROOT.DS.'core'.DS.'Router.php');


function __autoload($className)
{
    if (file_exists(ROOT.DS.'core'.DS.$className.'php')) {
        require_once(ROOT.DS.'core'.DS.$className.'php');
    } else if (file_exists(ROOT.DS.'controllers'.DS.$className.'php')) {
        require_once(ROOT . DS . 'controllers' . DS . $className . 'php');
    } else if (file_exists(ROOT.DS.'models'.DS.$className.'php')) {
        require_once(ROOT.DS.'controllers'.DS.$className.'php');
    }
}

// Router the request
Router::route($url);
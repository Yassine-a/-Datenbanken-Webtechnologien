<?php

class Router{
    public static function route($url)
    {
        //Controllers
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
        $controller_name = $controller;
        array_shift($url);

        // Action
        $action = (isset($url[0]) && $url[0] != '') ? ($url[0]) . 'Action' : indexAction;
        $action_name = $controller;
        array_shift($url);

        //Params
        $queryParams = $url;

        $dispatch = new $controller($controller_name, $action);

        //$dispatch->RegisterAction($queryParams);
        if (method_exists($controller, $action)) {
            call_user_func_array([$dispatch,$action],$queryParams);
        }else{
            die('Methode existiert nicht in der Kontroller\"'.$controller_name .'\"');
        }

    }
}
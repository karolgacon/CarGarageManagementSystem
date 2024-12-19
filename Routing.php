<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/AppController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/TaskController.php';

class Router {

    public static $routes;

    public static function get($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function run ($url) {
        $action = explode("/", $url)[0];
        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url! + $action + $url");
        }

        $controllerAction = explode("@", self::$routes[$action]);
        $controller = $controllerAction[0];
        $method = $controllerAction[1];

        $object = new $controller;
        $object->$method();
    }
}

<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/AppController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/MainController.php';
require_once 'src/controllers/InventoryController.php';
require_once 'src/controllers/UserController.php';
class Router {

    public static $routes;

    public static function get($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function run($url) {
        $action = explode("/", $url)[0];

        if (!array_key_exists($action, self::$routes)) {
            die("Invalid route: $action");
        }

        $controllerAction = explode("@", self::$routes[$action]);
        $controller = $controllerAction[0];
        $method = $controllerAction[1];


        if (!class_exists($controller)) {
            die("Controller class not found: $controller");
        }

        $object = new $controller;

        if (!method_exists($object, $method)) {
            die("Method not found: $method in controller $controller");
        }

        $object->$method();
    }


}

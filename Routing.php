<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/HomeController.php';

// TODO musimy zapewnic, ze utworzony 
// obiekt kontrollera ma tylko jedna instancję - SINGLETON

// TODO 2 /dashboard -- wszystkei dnae
// /dashboard/12234 -- wyciagnie nam jakis elemtn o wskaznaym ID 12234

// REGEX
class Routing {

     public static $routes = [
        "login" => [
            "controller" => "SecurityController",
            "action" => "login"
        ],
        "dashboard" => [
            "controller" => "DashboardController",
            "action" => "index"
        ],
        "home" => [
            "controller" => "HomeController",
            "action" => "index"
        ],
        "" => [
            "controller" => "SecurityController",
            "action" => "login"
        ],
        "nowy" => [
            "controller" => "SecurityController",
            "action" => "login2"
        ],
        "register" => [
            "controller" => "SecurityController",
            "action" => "register"
        ]
    ];


public static function run(string $path, $id = null) {
    if (!array_key_exists($path, self::$routes)) {
        include 'public/views/404.html';
        return;
    }

    $controller = self::$routes[$path]["controller"];
    $action = self::$routes[$path]["action"];

    $controllerObj = new $controller;
    $controllerObj->$action($id);
}

}
<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/HomeController.php';
require_once 'src/controllers/SpecialistController.php';
require_once 'src/controllers/LocationController.php';
require_once 'src/controllers/ApiSecurityController.php';
require_once 'src/controllers/ApiSpecialistController.php';
require_once 'src/controllers/ApiLocationController.php';
require_once 'src/controllers/ReviewController.php';

class Routing {

    public static $routes = [
        "login" => [
            "controller" => "SecurityController",
            "action" => "login"
        ],
        "logout" => [
            "controller" => "SecurityController",
            "action" => "logout"
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
            "controller" => "HomeController",
            "action" => "index"
        ],
        "register" => [
            "controller" => "SecurityController",
            "action" => "register"
        ],
        "specialists" => [
            "controller" => "SpecialistController",
            "action" => "specialists"
        ],
        "create-specialist" => [
            "controller" => "SpecialistController",
            "action" => "create"
        ],
        "locations" => [
            "controller" => "LocationController",
            "action" => "locations"
        ],
        "create-location" => [
            "controller" => "LocationController",
            "action" => "create"
        ],
        "pro-dashboard" => [
        "controller" => "DashboardController",
        "action" => "proDashboard"
        ],
        "expert-detail" => [
        "controller" => "SpecialistController",
        "action" => "expertDetail"
        ],
        "profile-settings" => [
        "controller" => "DashboardController",
        "action" => "profileSettings"
        ],
        "assign-location" => [
            "controller" => "SpecialistController",
            "action" => "assignLocation"
        ],
        "review" => [
            "controller" => "ReviewController",
            "action" => "create"
        ]
    ];

    public static $apiRoutes = [
        "api/login" => [
            "controller" => "ApiSecurityController",
            "action" => "login"
        ],
        "api/logout" => [
            "controller" => "ApiSecurityController",
            "action" => "logout"
        ],
        "api/specialists" => [
            "controller" => "ApiSpecialistController",
            "action" => "list"
        ],
        "api/specialist" => [
            "controller" => "ApiSpecialistController",
            "action" => "getById"
        ],
        "api/locations" => [
            "controller" => "ApiLocationController",
            "action" => "list"
        ]
    ];

    public static function run(string $path, $id = null) {
        // Check API routes first
        if (array_key_exists($path, self::$apiRoutes)) {
            $controller = self::$apiRoutes[$path]["controller"];
            $action = self::$apiRoutes[$path]["action"];
            $controllerObj = new $controller;
            $controllerObj->$action($id);
            return;
        }

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

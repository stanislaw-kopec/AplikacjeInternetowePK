<?php

session_start();

require_once __DIR__ . '/Routing.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');

$parts = explode('/', $path);
$route = $parts[0];
$id = $parts[1] ?? null;

Routing::run($route, $id);
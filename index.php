<?php

session_start();

require_once __DIR__ . '/Routing.php';
require_once __DIR__ . '/src/repositories/SchemaRepository.php';

(new SchemaRepository())->migrate();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($path, '/');

$parts = explode('/', $path);
$route = $parts[0];
$id = $parts[1] ?? null;

if ($route === 'api' && isset($parts[1])) {
    $route = $parts[0] . '/' . $parts[1];
    $id = $parts[2] ?? null;
}

Routing::run($route, $id);

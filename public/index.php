<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Registra el tiempo de inicio de Laravel.
define('LARAVEL_START', microtime(true));

// Verifica si la aplicación está en modo mantenimiento.
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Registra el autoloader de Composer.
require __DIR__.'/../vendor/autoload.php';

// Inicializa Laravel y maneja la petición.
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
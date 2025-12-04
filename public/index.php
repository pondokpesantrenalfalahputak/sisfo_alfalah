<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../sisfo-laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
// PATH DIPERBARUI: Menunjuk ke vendor/ di folder aman sisfo-laravel/
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
// PATH DIPERBARUI: Menunjuk ke bootstrap/ di folder aman sisfo-laravel/
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
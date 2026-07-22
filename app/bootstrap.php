<?php

session_start();

require_once __DIR__ . '/Core/DotEnv.php';

use App\Core\DotEnv;

// Load .env
(new DotEnv(__DIR__ . '/../.env'))->load();

// Constants
define('BASE_URL', $_ENV['APP_URL'] ?? 'http://localhost/donation-management-system');
define('APP_NAME', $_ENV['APP_NAME'] ?? 'Donation Management System');

// Autoload
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Load Helpers
require_once __DIR__ . '/Helpers/functions.php';

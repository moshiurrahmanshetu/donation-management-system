<?php

// Prevent header already sent issues
ob_start();

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Lax');

session_start();

require_once __DIR__ . '/Core/DotEnv.php';

use App\Core\DotEnv;

// Load .env
(new DotEnv(__DIR__ . '/../.env'))->load();

// Constants
define('BASE_URL', rtrim($_ENV['APP_URL'] ?? 'http://localhost/donation-management-system', '/'));
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

// Run migrations if needed (Check for display_name in roles)
try {
    $db = \App\Core\Database::getInstance()->getConnection();
    $check = $db->query("SHOW COLUMNS FROM roles LIKE 'display_name'")->fetch();
    if (!$check) {
        $sql = file_get_contents(__DIR__ . '/../update_roles_table.sql');
        $db->exec($sql);
    }

    // Check for modules table
    $checkModules = $db->query("SHOW TABLES LIKE 'modules'")->fetch();
    if (!$checkModules) {
        $sql = file_get_contents(__DIR__ . '/../update_permissions_table.sql');
        $db->exec($sql);
    } else {
        // Double check permissions table for new columns if modules already exists
        $checkP = $db->query("SHOW COLUMNS FROM permissions LIKE 'is_system'")->fetch();
        if (!$checkP) {
            // This is a safety check if the table existed but was old
            $sql = "ALTER TABLE `permissions` ADD COLUMN `is_system` tinyint(1) DEFAULT 0 AFTER `status`";
            $db->exec($sql);
        }
    }
} catch (\Exception $e) {
    error_log("Migration Error: " . $e->getMessage());
}

// Error Logging
$logFile = __DIR__ . '/../storage/logs/error.log';
ini_set('log_errors', 1);
ini_set('error_log', $logFile);

if (!file_exists($logFile)) {
    touch($logFile);
    chmod($logFile, 0666);
}

// Prevent browser caching for protected pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

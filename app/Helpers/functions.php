<?php

function view($view, $data = []) {
    extract($data);
    $viewFile = __DIR__ . "/../../resources/views/" . str_replace('.', '/', $view) . ".php";
    if (file_exists($viewFile)) {
        require_once $viewFile;
    }
}

function asset($path) {
    return BASE_URL . "/public/assets/" . ltrim($path, '/');
}

function url($path = '') {
    $path = ltrim($path, '/');
    return $path === '' ? BASE_URL : BASE_URL . '/' . $path;
}

function redirect($path) {
    header("Location: " . url($path));
    exit;
}

function session_set($key, $value) {
    $_SESSION[$key] = $value;
}

function session_get($key, $default = null) {
    return $_SESSION[$key] ?? $default;
}

function session_has($key) {
    return isset($_SESSION[$key]);
}

function session_remove($key) {
    unset($_SESSION[$key]);
}

function old($key, $default = '') {
    return $_SESSION['old'][$key] ?? $default;
}

function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function status_badge($status) {
    $class = match($status) {
        'active', 'success', 'online' => 'bg-success',
        'pending', 'warning' => 'bg-warning text-dark',
        'inactive', 'danger', 'offline' => 'bg-danger',
        default => 'bg-secondary'
    };
    return "<span class='badge $class'>" . ucfirst($status) . "</span>";
}

function format_currency($amount) {
    return '$' . number_format($amount, 2);
}

function format_date($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

function get_php_version() { return PHP_VERSION; }
function get_mysql_version() {
    $db = \App\Core\Database::getInstance()->getConnection();
    return $db->getAttribute(\PDO::ATTR_SERVER_VERSION);
}
function get_server_info() { return $_SERVER['SERVER_SOFTWARE']; }

function get_storage_status() {
    $free = disk_free_space("/");
    $total = disk_total_space("/");
    $used = $total - $free;
    $percent = round(($used / $total) * 100, 2);
    return [
        'total' => format_bytes($total),
        'used' => format_bytes($used),
        'free' => format_bytes($free),
        'percent' => $percent
    ];
}

function format_bytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

function get_total_users() {
    $db = \App\Core\Database::getInstance()->getConnection();
    return $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
}

function get_total_roles() {
    $db = \App\Core\Database::getInstance()->getConnection();
    return $db->query("SELECT COUNT(*) FROM roles")->fetchColumn();
}

function get_total_permissions() {
    $db = \App\Core\Database::getInstance()->getConnection();
    return $db->query("SELECT COUNT(*) FROM permissions")->fetchColumn();
}



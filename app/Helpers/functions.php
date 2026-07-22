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
    return BASE_URL . "/" . ltrim($path, '/');
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

<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // Session Timeout Check (30 minutes)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            session_unset();
            session_destroy();
            header("Location: " . BASE_URL . "/login?timeout=1");
            exit;
        }
        $_SESSION['last_activity'] = time();
    }
}

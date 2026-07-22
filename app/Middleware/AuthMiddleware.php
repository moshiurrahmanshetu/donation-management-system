<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        // If user is NOT logged in, redirect to login
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // Session Timeout Check (30 minutes = 1800 seconds)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            session_unset();
            session_destroy();
            header("Location: " . BASE_URL . "/login?timeout=1");
            exit;
        }
        
        $_SESSION['last_activity'] = time();
    }
}

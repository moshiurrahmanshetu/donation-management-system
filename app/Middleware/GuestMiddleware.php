<?php

namespace App\Middleware;

class GuestMiddleware
{
    public function handle()
    {
        // If user IS logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/dashboard");
            exit;
        }
    }
}

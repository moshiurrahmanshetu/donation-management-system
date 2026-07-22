<?php

namespace App\Middleware;

class RoleMiddleware
{
    public function handle($allowedRoles = [])
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $userRole = $_SESSION['user_role'] ?? '';

        // Super Admin has access to everything
        if ($userRole === 'super-admin') {
            return;
        }

        if (!in_array($userRole, $allowedRoles)) {
            http_response_code(403);
            die("403 - Unauthorized access. You do not have the required role to access this page.");
        }
    }
}

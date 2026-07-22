<?php

namespace App\Middleware;

class RoleMiddleware
{
    public function handle($allowedRoles)
    {
        $userRole = $_SESSION['user_role'] ?? '';
        
        if (!in_array($userRole, $allowedRoles)) {
            http_response_code(403);
            die("Unauthorized Access");
        }
    }
}

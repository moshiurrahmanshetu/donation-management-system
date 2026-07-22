<?php

namespace App\Middleware;

use App\Core\Database;

class PermissionMiddleware
{
    public function handle($permissionSlug)
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            http_response_code(403);
            die("Unauthorized");
        }

        $db = Database::getInstance()->getConnection();
        $sql = "SELECT p.slug FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                JOIN user_roles ur ON rp.role_id = ur.role_id 
                WHERE ur.user_id = ? AND p.slug = ?";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId, $permissionSlug]);
        
        if (!$stmt->fetch()) {
            http_response_code(403);
            die("Permission Denied");
        }
    }
}

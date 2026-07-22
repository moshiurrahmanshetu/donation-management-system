<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, status) 
                VALUES (:username, :email, :password, :first_name, :last_name, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getRoles($userId)
    {
        $sql = "SELECT r.* FROM roles r 
                JOIN user_roles ur ON r.id = ur.role_id 
                WHERE ur.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function logLogin($data)
    {
        $sql = "INSERT INTO login_logs (user_id, username, ip_address, user_agent, status) 
                VALUES (:user_id, :username, :ip_address, :user_agent, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getFailedAttempts($username, $ip, $minutes = 15)
    {
        $sql = "SELECT COUNT(*) as count FROM login_logs 
                WHERE (username = :username OR ip_address = :ip) 
                AND status = 'failed' 
                AND attempted_at > DATE_SUB(NOW(), INTERVAL :minutes MINUTE)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username, 'ip' => $ip, 'minutes' => $minutes]);
        return $stmt->fetch()['count'];
    }

    public function updateResetToken($email, $token, $expiry)
    {
        $sql = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$token, $expiry, $email]);
    }

    public function findByResetToken($token)
    {
        $sql = "SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function updatePassword($userId, $password)
    {
        $sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$password, $userId]);
    }
}

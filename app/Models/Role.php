<?php

namespace App\Models;

use App\Core\Model;

class Role extends Model
{
    public function all()
    {
        $sql = "SELECT r.*, 
                u1.username as creator_name, 
                u2.username as updater_name,
                (SELECT COUNT(*) FROM user_roles ur WHERE ur.role_id = r.id) as user_count,
                (SELECT COUNT(*) FROM role_permissions rp WHERE rp.role_id = r.id) as permission_count
                FROM roles r
                LEFT JOIN users u1 ON r.created_by = u1.id
                LEFT JOIN users u2 ON r.updated_by = u2.id
                ORDER BY r.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT r.*, 
                u1.username as creator_name, 
                u2.username as updater_name,
                (SELECT COUNT(*) FROM user_roles ur WHERE ur.role_id = r.id) as user_count,
                (SELECT COUNT(*) FROM role_permissions rp WHERE rp.role_id = r.id) as permission_count
                FROM roles r
                LEFT JOIN users u1 ON r.created_by = u1.id
                LEFT JOIN users u2 ON r.updated_by = u2.id
                WHERE r.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM roles WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO roles (name, display_name, slug, description, status, created_by) 
                VALUES (:name, :display_name, :slug, :description, :status, :created_by)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE roles SET 
                name = :name, 
                display_name = :display_name, 
                slug = :slug, 
                description = :description, 
                status = :status, 
                updated_by = :updated_by 
                WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM roles WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateStatus($id, $status, $updatedBy)
    {
        $stmt = $this->db->prepare("UPDATE roles SET status = ?, updated_by = ? WHERE id = ?");
        return $stmt->execute([$status, $updatedBy, $id]);
    }

    public function isSystemRole($id)
    {
        $role = $this->find($id);
        if (!$role) return false;
        return in_array($role['slug'], ['super-admin', 'admin', 'user']);
    }
}

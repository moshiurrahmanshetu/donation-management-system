<?php

namespace App\Models;

use App\Core\Model;

class Permission extends Model
{
    public function all()
    {
        $sql = "SELECT p.*, m.name as module_name 
                FROM permissions p 
                LEFT JOIN modules m ON p.module_id = m.id 
                ORDER BY m.name ASC, p.name ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO permissions (module_id, name, slug, description, status, is_system, created_by) 
                VALUES (:module_id, :name, :slug, :description, :status, :is_system, :created_by)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function generateDefaultPermissions($moduleId, $moduleSlug, $createdBy)
    {
        $permissions = [
            ['name' => 'View', 'slug' => $moduleSlug . '.view'],
            ['name' => 'Create', 'slug' => $moduleSlug . '.create'],
            ['name' => 'Edit', 'slug' => $moduleSlug . '.edit'],
            ['name' => 'Delete', 'slug' => $moduleSlug . '.delete'],
        ];

        foreach ($permissions as $p) {
            $data = [
                'module_id' => $moduleId,
                'name' => $p['name'],
                'slug' => $p['slug'],
                'description' => $p['name'] . ' ' . $moduleSlug,
                'status' => 'active',
                'is_system' => 0,
                'created_by' => $createdBy
            ];
            $this->create($data);
        }
    }

    public function update($id, $data)
    {
        $sql = "UPDATE permissions SET 
                name = :name, 
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
        $stmt = $this->db->prepare("DELETE FROM permissions WHERE id = ? AND is_system = 0");
        return $stmt->execute([$id]);
    }
}

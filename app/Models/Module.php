<?php

namespace App\Models;

use App\Core\Model;

class Module extends Model
{
    public function all()
    {
        return $this->db->query("SELECT * FROM modules ORDER BY name ASC")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM modules WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM modules WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO modules (name, slug, description, status, is_system, created_by) 
                VALUES (:name, :slug, :description, :status, :is_system, :created_by)";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($data)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data)
    {
        $sql = "UPDATE modules SET 
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
        $stmt = $this->db->prepare("DELETE FROM modules WHERE id = ? AND is_system = 0");
        return $stmt->execute([$id]);
    }
}

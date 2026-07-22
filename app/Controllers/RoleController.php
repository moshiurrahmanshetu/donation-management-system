<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Role;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

class RoleController extends Controller
{
    protected $roleModel;

    public function __construct()
    {
        (new AuthMiddleware())->handle();
        // Only Super Admin can access Role Management
        (new RoleMiddleware())->handle(['super-admin']);
        
        $this->roleModel = new Role();
    }

    public function index()
    {
        $this->view('roles.index', [
            'title' => 'Role Management',
            'breadcrumb' => [
                ['name' => 'Dashboard', 'url' => url('dashboard'), 'active' => false],
                ['name' => 'Roles', 'url' => url('roles'), 'active' => true]
            ]
        ]);
    }

    public function list()
    {
        $roles = $this->roleModel->all();
        $this->json(['status' => 'success', 'data' => $roles]);
    }

    public function store()
    {
        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $this->json(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        }

        $name = trim($_POST['name'] ?? '');
        $displayName = trim($_POST['display_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'active';
        $slug = strtolower(str_replace(' ', '-', $name));

        // Validation
        if (empty($name) || empty($displayName)) {
            $this->json(['status' => 'error', 'message' => 'Role Name and Display Name are required.']);
        }

        if ($this->roleModel->findBySlug($slug)) {
            $this->json(['status' => 'error', 'message' => 'Role Name already exists.']);
        }

        $data = [
            'name' => $name,
            'display_name' => $displayName,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
            'created_by' => $_SESSION['user_id']
        ];

        if ($this->roleModel->create($data)) {
            $this->json(['status' => 'success', 'message' => 'Role created successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to create role.']);
        }
    }

    public function edit($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            $this->json(['status' => 'error', 'message' => 'Role not found.']);
        }
        $this->json(['status' => 'success', 'data' => $role]);
    }

    public function update($id)
    {
        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $this->json(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        }

        $role = $this->roleModel->find($id);
        if (!$role) {
            $this->json(['status' => 'error', 'message' => 'Role not found.']);
        }

        $name = trim($_POST['name'] ?? '');
        $displayName = trim($_POST['display_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'active';
        $slug = strtolower(str_replace(' ', '-', $name));

        if (empty($name) || empty($displayName)) {
            $this->json(['status' => 'error', 'message' => 'Role Name and Display Name are required.']);
        }

        $existing = $this->roleModel->findBySlug($slug);
        if ($existing && $existing['id'] != $id) {
            $this->json(['status' => 'error', 'message' => 'Role Name already exists.']);
        }

        $data = [
            'name' => $name,
            'display_name' => $displayName,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
            'updated_by' => $_SESSION['user_id']
        ];

        if ($this->roleModel->update($id, $data)) {
            $this->json(['status' => 'success', 'message' => 'Role updated successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to update role.']);
        }
    }

    public function delete($id)
    {
        if ($this->roleModel->isSystemRole($id)) {
            $this->json(['status' => 'error', 'message' => 'This system role cannot be deleted.']);
        }

        if ($this->roleModel->delete($id)) {
            $this->json(['status' => 'success', 'message' => 'Role deleted successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to delete role.']);
        }
    }

    public function toggleStatus($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            $this->json(['status' => 'error', 'message' => 'Role not found.']);
        }

        if ($this->roleModel->isSystemRole($id)) {
            $this->json(['status' => 'error', 'message' => 'Status of system roles cannot be changed.']);
        }

        $newStatus = ($role['status'] === 'active') ? 'inactive' : 'active';
        if ($this->roleModel->updateStatus($id, $newStatus, $_SESSION['user_id'])) {
            $this->json(['status' => 'success', 'message' => 'Status updated to ' . $newStatus]);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to update status.']);
        }
    }

    public function show($id)
    {
        $role = $this->roleModel->find($id);
        if (!$role) {
            $this->redirect('roles');
        }

        $this->view('roles.show', [
            'title' => 'Role Details',
            'role' => $role,
            'breadcrumb' => [
                ['name' => 'Dashboard', 'url' => url('dashboard'), 'active' => false],
                ['name' => 'Roles', 'url' => url('roles'), 'active' => false],
                ['name' => 'Details', 'url' => '', 'active' => true]
            ]
        ]);
    }
}

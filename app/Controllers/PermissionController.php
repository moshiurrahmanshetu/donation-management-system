<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Module;
use App\Models\Permission;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

class PermissionController extends Controller
{
    protected $moduleModel;
    protected $permissionModel;

    public function __construct()
    {
        (new AuthMiddleware())->handle();
        (new RoleMiddleware())->handle(['super-admin']);
        
        $this->moduleModel = new Module();
        $this->permissionModel = new Permission();
    }

    public function index()
    {
        $this->view('permissions.index', [
            'title' => 'Permission Management',
            'modules' => $this->moduleModel->all(),
            'breadcrumb' => [
                ['name' => 'Dashboard', 'url' => url('dashboard'), 'active' => false],
                ['name' => 'Permissions', 'url' => url('permissions'), 'active' => true]
            ]
        ]);
    }

    public function list()
    {
        $permissions = $this->permissionModel->all();
        $this->json(['status' => 'success', 'data' => $permissions]);
    }

    public function store()
    {
        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $this->json(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        }

        $moduleId = $_POST['module_id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($moduleId) || empty($name) || empty($slug)) {
            $this->json(['status' => 'error', 'message' => 'Module, Name and Key are required.']);
        }

        if ($this->permissionModel->findBySlug($slug)) {
            $this->json(['status' => 'error', 'message' => 'Permission Key already exists.']);
        }

        $data = [
            'module_id' => $moduleId,
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'status' => 'active',
            'is_system' => 0,
            'created_by' => $_SESSION['user_id']
        ];

        if ($this->permissionModel->create($data)) {
            $this->json(['status' => 'success', 'message' => 'Permission created successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to create permission.']);
        }
    }

    public function edit($id)
    {
        $permission = $this->permissionModel->find($id);
        if (!$permission) {
            $this->json(['status' => 'error', 'message' => 'Permission not found.']);
        }
        $this->json(['status' => 'success', 'data' => $permission]);
    }

    public function update($id)
    {
        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $this->json(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        }

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'active';

        if (empty($name) || empty($slug)) {
            $this->json(['status' => 'error', 'message' => 'Name and Key are required.']);
        }

        $existing = $this->permissionModel->findBySlug($slug);
        if ($existing && $existing['id'] != $id) {
            $this->json(['status' => 'error', 'message' => 'Permission Key already exists.']);
        }

        $data = [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'status' => $status,
            'updated_by' => $_SESSION['user_id']
        ];

        if ($this->permissionModel->update($id, $data)) {
            $this->json(['status' => 'success', 'message' => 'Permission updated successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to update permission.']);
        }
    }

    public function delete($id)
    {
        $permission = $this->permissionModel->find($id);
        if ($permission && $permission['is_system']) {
            $this->json(['status' => 'error', 'message' => 'This is a protected permission.']);
        }

        if ($this->permissionModel->delete($id)) {
            $this->json(['status' => 'success', 'message' => 'Permission deleted successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to delete permission.']);
        }
    }

    // Module Management
    public function modules()
    {
        $this->view('permissions.modules', [
            'title' => 'Module Management',
            'breadcrumb' => [
                ['name' => 'Dashboard', 'url' => url('dashboard'), 'active' => false],
                ['name' => 'Permissions', 'url' => url('permissions'), 'active' => false],
                ['name' => 'Modules', 'url' => '', 'active' => true]
            ]
        ]);
    }

    public function moduleList()
    {
        $modules = $this->moduleModel->all();
        $this->json(['status' => 'success', 'data' => $modules]);
    }

    public function moduleStore()
    {
        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $this->json(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        }

        $name = trim($_POST['name'] ?? '');
        $slug = strtolower(str_replace(' ', '-', $name));
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $this->json(['status' => 'error', 'message' => 'Module Name is required.']);
        }

        if ($this->moduleModel->findBySlug($slug)) {
            $this->json(['status' => 'error', 'message' => 'Module already exists.']);
        }

        $data = [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'status' => 'active',
            'is_system' => 0,
            'created_by' => $_SESSION['user_id']
        ];

        $moduleId = $this->moduleModel->create($data);
        if ($moduleId) {
            // Automatically generate CRUD permissions
            $this->permissionModel->generateDefaultPermissions($moduleId, $slug, $_SESSION['user_id']);
            $this->json(['status' => 'success', 'message' => 'Module and default permissions created!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to create module.']);
        }
    }

    public function moduleDelete($id)
    {
        $module = $this->moduleModel->find($id);
        if ($module && $module['is_system']) {
            $this->json(['status' => 'error', 'message' => 'This is a system module and cannot be deleted.']);
        }

        if ($this->moduleModel->delete($id)) {
            $this->json(['status' => 'success', 'message' => 'Module deleted successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Failed to delete module.']);
        }
    }
}

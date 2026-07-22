<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Permission List</h6>
        <div class="header-actions">
            <a href="<?= url('permissions/modules') ?>" class="btn btn-outline-primary btn-sm me-1">
                <i class="bi bi-grid me-1"></i> Manage Modules
            </a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                <i class="bi bi-plus-circle me-1"></i> Add Permission
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="permissionsTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Module</th>
                        <th>Permission Name</th>
                        <th>Permission Key</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="createPermissionForm">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Module</label>
                        <select name="module_id" class="form-select" required>
                            <option value="">Select Module</option>
                            <?php foreach ($modules as $module): ?>
                                <option value="<?= $module['id'] ?>"><?= $module['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permission Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Create User">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permission Key (Unique)</label>
                        <input type="text" name="slug" class="form-control" required placeholder="e.g. users.create">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="editPermissionForm">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <input type="hidden" name="id" id="edit_permission_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Permission Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permission Key</label>
                        <input type="text" name="slug" id="edit_slug" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const table = $('#permissionsTable').DataTable({
        ajax: '<?= url('permissions/list') ?>',
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'module_name', render: data => `<span class="badge bg-secondary">${data}</span>` },
            { data: 'name' },
            { data: 'slug', render: data => `<code class="text-primary">${data}</code>` },
            { 
                data: 'status',
                render: data => status_badge(data)
            },
            { 
                data: 'created_at',
                render: data => new Date(data).toLocaleDateString()
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary edit-btn" data-id="${row.id}" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.id}" ${row.is_system == 1 ? 'disabled' : ''} title="Delete"><i class="bi bi-trash"></i></button>
                        </div>
                    `;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });

    // Create Permission
    $('#createPermissionForm').submit(function(e) {
        e.preventDefault();
        $.post('<?= url('permissions/store') ?>', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                showAlert('success', res.message);
                $('#createPermissionModal').modal('hide');
                $('#createPermissionForm')[0].reset();
                table.ajax.reload();
            } else {
                showAlert('error', res.message);
            }
        }, 'json');
    });

    // Edit Permission - Load Data
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        $.get('<?= url('permissions/edit') ?>/' + id, function(res) {
            if (res.status === 'success') {
                const p = res.data;
                $('#edit_permission_id').val(p.id);
                $('#edit_name').val(p.name);
                $('#edit_slug').val(p.slug);
                $('#edit_description').val(p.description);
                $('#edit_status').val(p.status);
                $('#editPermissionModal').modal('show');
            }
        }, 'json');
    });

    // Update Permission
    $('#editPermissionForm').submit(function(e) {
        e.preventDefault();
        const id = $('#edit_permission_id').val();
        $.post('<?= url('permissions/update') ?>/' + id, $(this).serialize(), function(res) {
            if (res.status === 'success') {
                showAlert('success', res.message);
                $('#editPermissionModal').modal('hide');
                table.ajax.reload();
            } else {
                showAlert('error', res.message);
            }
        }, 'json');
    });

    // Delete Permission
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= url('permissions/delete') ?>/' + id, {csrf_token: '<?= csrf_token() ?>'}, function(res) {
                    if (res.status === 'success') {
                        showAlert('success', res.message);
                        table.ajax.reload();
                    } else {
                        showAlert('error', res.message);
                    }
                }, 'json');
            }
        });
    });
});
</script>

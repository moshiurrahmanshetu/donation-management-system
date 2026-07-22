<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Role List</h6>
        <div class="header-actions">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="bi bi-plus-circle me-1"></i> Add New Role
            </button>
            <button class="btn btn-outline-secondary btn-sm" id="refreshTable">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="rolesTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Role Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="createRoleForm">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role Name (Internal)</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Content Manager">
                        <small class="text-muted">Used for slug generation.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Name</label>
                        <input type="text" name="display_name" class="form-control" required placeholder="e.g. Content Manager">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="editRoleForm">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <input type="hidden" name="id" id="edit_role_id">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role Name (Internal)</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Name</label>
                        <input type="text" name="display_name" id="edit_display_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
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
                    <button type="submit" class="btn btn-primary">Update Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const table = $('#rolesTable').DataTable({
        ajax: '<?= url('roles/list') ?>',
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name' },
            { data: 'display_name' },
            { data: 'description' },
            { 
                data: 'status',
                render: function(data, type, row) {
                    const badgeClass = data === 'active' ? 'bg-success' : 'bg-danger';
                    const isSystem = ['super-admin', 'admin', 'user'].includes(row.slug);
                    return `<span class="badge ${badgeClass} status-toggle" data-id="${row.id}" style="cursor:${isSystem ? 'default' : 'pointer'}">${data.toUpperCase()}</span>`;
                }
            },
            { 
                data: 'created_at',
                render: data => new Date(data).toLocaleDateString()
            },
            {
                data: null,
                render: function(data, type, row) {
                    const isSystem = ['super-admin', 'admin', 'user'].includes(row.slug);
                    return `
                        <div class="btn-group">
                            <a href="<?= url('roles/show') ?>/${row.id}" class="btn btn-sm btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                            <button class="btn btn-sm btn-outline-primary edit-btn" data-id="${row.id}" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.id}" ${isSystem ? 'disabled' : ''} title="Delete"><i class="bi bi-trash"></i></button>
                        </div>
                    `;
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });

    $('#refreshTable').click(() => table.ajax.reload());

    // Create Role
    $('#createRoleForm').submit(function(e) {
        e.preventDefault();
        $.post('<?= url('roles/store') ?>', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                showAlert('success', res.message);
                $('#createRoleModal').modal('hide');
                $('#createRoleForm')[0].reset();
                table.ajax.reload();
            } else {
                showAlert('error', res.message);
            }
        }, 'json');
    });

    // Edit Role - Load Data
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        $.get('<?= url('roles/edit') ?>/' + id, function(res) {
            if (res.status === 'success') {
                const role = res.data;
                $('#edit_role_id').val(role.id);
                $('#edit_name').val(role.name);
                $('#edit_display_name').val(role.display_name);
                $('#edit_description').val(role.description);
                $('#edit_status').val(role.status);
                $('#editRoleModal').modal('show');
            }
        }, 'json');
    });

    // Update Role
    $('#editRoleForm').submit(function(e) {
        e.preventDefault();
        const id = $('#edit_role_id').val();
        $.post('<?= url('roles/update') ?>/' + id, $(this).serialize(), function(res) {
            if (res.status === 'success') {
                showAlert('success', res.message);
                $('#editRoleModal').modal('hide');
                table.ajax.reload();
            } else {
                showAlert('error', res.message);
            }
        }, 'json');
    });

    // Delete Role
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= url('roles/delete') ?>/' + id, {csrf_token: '<?= csrf_token() ?>'}, function(res) {
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

    // Toggle Status
    $(document).on('click', '.status-toggle', function() {
        const id = $(this).data('id');
        $.post('<?= url('roles/toggle-status') ?>/' + id, {csrf_token: '<?= csrf_token() ?>'}, function(res) {
            if (res.status === 'success') {
                table.ajax.reload();
            } else {
                showAlert('error', res.message);
            }
        }, 'json');
    });
});
</script>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Module Management</h6>
        <div class="header-actions">
            <a href="<?= url('permissions') ?>" class="btn btn-outline-secondary btn-sm me-1">
                <i class="bi bi-arrow-left me-1"></i> Back to Permissions
            </a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModuleModal">
                <i class="bi bi-plus-circle me-1"></i> Add New Module
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="modulesTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Module Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Module Modal -->
<div class="modal fade" id="createModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="createModuleForm">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Module Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Inventory">
                        <small class="text-muted">System will automatically generate CRUD permissions for this module.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Module</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const table = $('#modulesTable').DataTable({
        ajax: '<?= url('permissions/module-list') ?>',
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name' },
            { data: 'slug', render: data => `<code class="text-primary">${data}</code>` },
            { data: 'description' },
            { 
                data: 'status',
                render: data => status_badge(data)
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.id}" ${row.is_system == 1 ? 'disabled' : ''} title="Delete"><i class="bi bi-trash"></i></button>
                        </div>
                    `;
                }
            }
        ]
    });

    // Create Module
    $('#createModuleForm').submit(function(e) {
        e.preventDefault();
        $.post('<?= url('permissions/module-store') ?>', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                showAlert('success', res.message);
                $('#createModuleModal').modal('hide');
                $('#createModuleForm')[0].reset();
                table.ajax.reload();
            } else {
                showAlert('error', res.message);
            }
        }, 'json');
    });

    // Delete Module
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This will NOT delete existing permissions associated with this module.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= url('permissions/module-delete') ?>/' + id, {csrf_token: '<?= csrf_token() ?>'}, function(res) {
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

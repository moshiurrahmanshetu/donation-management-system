<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Role Overview</h6>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-lock fs-1"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1"><?= htmlspecialchars($role['display_name']) ?></h4>
                <p class="text-muted mb-3"><?= htmlspecialchars($role['name']) ?></p>
                <div class="mb-3">
                    <?= status_badge($role['status']) ?>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <h5 class="fw-bold mb-0"><?= $role['user_count'] ?></h5>
                        <small class="text-muted">Assigned Users</small>
                    </div>
                    <div class="col-6">
                        <h5 class="fw-bold mb-0"><?= $role['permission_count'] ?></h5>
                        <small class="text-muted">Permissions</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Role Details</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%" class="bg-light">Internal Name</th>
                        <td><?= htmlspecialchars($role['name']) ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Display Name</th>
                        <td><?= htmlspecialchars($role['display_name']) ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Slug</th>
                        <td><code class="text-primary"><?= htmlspecialchars($role['slug']) ?></code></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Description</th>
                        <td><?= nl2br(htmlspecialchars($role['description'] ?? 'No description provided.')) ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Created By</th>
                        <td><?= htmlspecialchars($role['creator_name'] ?? 'System') ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Created At</th>
                        <td><?= format_date($role['created_at'], 'M d, Y h:i A') ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Last Updated By</th>
                        <td><?= htmlspecialchars($role['updater_name'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Last Updated At</th>
                        <td><?= format_date($role['updated_at'], 'M d, Y h:i A') ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer bg-transparent border-top-0 text-end">
                <a href="<?= url('roles') ?>" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
                <button class="btn btn-primary btn-sm edit-btn" data-id="<?= $role['id'] ?>">
                    <i class="bi bi-pencil me-1"></i> Edit Role
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal (Simplified version for Show page) -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="editRoleForm">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <input type="hidden" name="id" id="edit_role_id" value="<?= $role['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role Name (Internal)</label>
                        <input type="text" name="name" id="edit_name" class="form-control" value="<?= htmlspecialchars($role['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Name</label>
                        <input type="text" name="display_name" id="edit_display_name" class="form-control" value="<?= htmlspecialchars($role['display_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"><?= htmlspecialchars($role['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="active" <?= $role['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $role['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
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
    $('.edit-btn').click(function() {
        $('#editRoleModal').modal('show');
    });

    $('#editRoleForm').submit(function(e) {
        e.preventDefault();
        const id = $('#edit_role_id').val();
        $.post('<?= url('roles/update') ?>/' + id, $(this).serialize(), function(res) {
            if (res.status === 'success') {
                showAlert('success', res.message, function() {
                    location.reload();
                });
            } else {
                showAlert('error', res.message);
            }
        }, 'json');
    });
});
</script>

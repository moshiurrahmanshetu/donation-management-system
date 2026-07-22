<h4 class="text-center mb-4">Reset Password</h4>
<form id="resetForm">
    <input type="hidden" name="token" value="<?= $token ?>">
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" required placeholder="Enter new password">
            <span class="input-group-text password-toggle toggle-password"><i class="bi bi-eye"></i></span>
        </div>
    </div>
    <div class="mb-4">
        <label class="form-label">Confirm New Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="confirm_password" class="form-control" required placeholder="Confirm new password">
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100 mb-3">Reset Password</button>
</form>

<script>
$(document).ready(function() {
    $('#resetForm').on('submit', function(e) {
        e.preventDefault();
        if ($('input[name="password"]').val() !== $('input[name="confirm_password"]').val()) {
            showAlert('error', 'Passwords do not match!');
            return;
        }

        const btn = $(this).find('button');
        btn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: '<?= url('reset-password') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                    setTimeout(() => window.location.href = response.redirect, 2000);
                } else {
                    showAlert('error', response.message);
                    btn.prop('disabled', false).text('Reset Password');
                }
            },
            error: function() {
                showAlert('error', 'Something went wrong.');
                btn.prop('disabled', false).text('Reset Password');
            }
        });
    });
});
</script>

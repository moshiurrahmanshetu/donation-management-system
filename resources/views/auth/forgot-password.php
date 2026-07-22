<h4 class="text-center mb-4">Forgot Password</h4>
<p class="text-muted text-center mb-4">Enter your email address and we'll send you a link to reset your password.</p>
<form id="forgotForm">
    <div class="mb-4">
        <label class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control" required placeholder="name@example.com">
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100 mb-3">Send Reset Link</button>
    <div class="text-center">
        <a href="<?= url('login') ?>" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Login</a>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#forgotForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $(this).find('button');
        btn.prop('disabled', true).text('Sending...');

        $.ajax({
            url: '<?= url('forgot-password') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                } else {
                    showAlert('error', response.message);
                }
                btn.prop('disabled', false).text('Send Reset Link');
            },
            error: function() {
                showAlert('error', 'Something went wrong.');
                btn.prop('disabled', false).text('Send Reset Link');
            }
        });
    });
});
</script>

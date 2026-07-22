<h4 class="text-center mb-4">Login</h4>
<form id="loginForm" method="POST" action="<?= url('login') ?>">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
    <div class="mb-3">
        <label class="form-label">Email or Username</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="username" class="form-control" required placeholder="Enter email or username">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" required placeholder="Enter password">
            <span class="input-group-text password-toggle toggle-password"><i class="bi bi-eye"></i></span>
        </div>
    </div>
    <div class="d-flex justify-content-between mb-4">
        <div class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        <a href="<?= url('forgot-password') ?>" class="text-decoration-none">Forgot Password?</a>
    </div>
    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
    <div class="text-center">
        <span>Don't have an account? <a href="<?= url('signup') ?>" class="text-decoration-none">Sign Up</a></span>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $(this).find('button');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Logging in...');

        $.ajax({
            url: '<?= url('login') ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', 'Login successful!', function() {
                        window.location.href = response.redirect;
                    });
                } else {
                    showAlert('error', response.message);
                    btn.prop('disabled', false).text('Login');
                }
            },
            error: function() {
                showAlert('error', 'Something went wrong.');
                btn.prop('disabled', false).text('Login');
            }
        });
    });
});
</script>

<h4 class="text-center mb-4">Sign Up</h4>
<form id="signupForm">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" required>
            <span class="input-group-text password-toggle toggle-password"><i class="bi bi-eye"></i></span>
        </div>
        <div class="progress mt-2" style="height: 5px;">
            <div id="password-strength" class="progress-bar" role="progressbar" style="width: 0%"></div>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="terms" required>
        <label class="form-check-label" for="terms">I agree to the <a href="#">Terms & Conditions</a></label>
    </div>
    <button type="submit" class="btn btn-primary w-100 mb-3">Sign Up</button>
    <div class="text-center">
        <span>Already have an account? <a href="<?= url('login') ?>" class="text-decoration-none">Login</a></span>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#password').on('input', function() {
        const val = $(this).val();
        let strength = 0;
        if (val.length > 6) strength += 25;
        if (val.match(/[a-z]/) && val.match(/[A-Z]/)) strength += 25;
        if (val.match(/[0-9]/)) strength += 25;
        if (val.match(/[^a-zA-Z0-9]/)) strength += 25;

        const bar = $('#password-strength');
        bar.css('width', strength + '%');
        if (strength < 50) bar.addClass('bg-danger').removeClass('bg-warning bg-success');
        else if (strength < 100) bar.addClass('bg-warning').removeClass('bg-danger bg-success');
        else bar.addClass('bg-success').removeClass('bg-danger bg-warning');
    });

    $('#signupForm').on('submit', function(e) {
        e.preventDefault();
        if ($('#password').val() !== $('input[name="confirm_password"]').val()) {
            showAlert('error', 'Passwords do not match!');
            return;
        }

        const btn = $(this).find('button');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

        $.ajax({
            url: '<?= url('signup') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                    setTimeout(() => window.location.href = response.redirect, 2000);
                } else {
                    showAlert('error', response.message);
                    btn.prop('disabled', false).text('Sign Up');
                }
            },
            error: function() {
                showAlert('error', 'Something went wrong.');
                btn.prop('disabled', false).text('Sign Up');
            }
        });
    });
});
</script>

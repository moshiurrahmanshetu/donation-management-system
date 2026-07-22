<?php if (session_has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session_get('success') ?>
        <?php session_remove('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session_has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session_get('error') ?>
        <?php session_remove('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

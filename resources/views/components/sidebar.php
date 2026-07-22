<div id="sidebar">
    <div class="p-4 border-bottom">
        <h5 class="fw-bold mb-0"><?= APP_NAME ?></h5>
    </div>
    <nav class="mt-3">
        <a href="<?= url('dashboard') ?>" class="nav-link <?= (isset($title) && $title == 'Dashboard') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-heart"></i> Donations
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-people"></i> Donors
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-megaphone"></i> Campaigns
        </a>
        <hr>
        <a href="<?= url('logout') ?>" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
</div>

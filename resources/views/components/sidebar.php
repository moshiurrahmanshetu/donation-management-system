<aside id="sidebar">
    <div class="sidebar-brand p-3 d-flex align-items-center gap-2">
        <div class="bg-primary text-white p-2 rounded">
            <i class="bi bi-heart-fill"></i>
        </div>
        <span class="fw-bold sidebar-text"><?= APP_NAME ?></span>
    </div>
    
    <div class="sidebar-scroll overflow-auto" style="height: calc(100vh - 70px);">
        <nav class="nav flex-column mt-2">
            <div class="sidebar-heading px-4 py-2 small text-uppercase opacity-50 sidebar-text">Core</div>
            <a href="<?= url('dashboard') ?>" class="nav-link active">
                <i class="bi bi-speedometer2"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <div class="sidebar-heading px-4 py-2 mt-3 small text-uppercase opacity-50 sidebar-text">Management</div>
            
            <!-- User Management -->
            <a class="nav-link" data-bs-toggle="collapse" href="#userSubmenu" role="button">
                <i class="bi bi-people"></i>
                <span class="sidebar-text">User Management</span>
                <i class="bi bi-chevron-down ms-auto submenu-arrow small"></i>
            </a>
            <div class="collapse" id="userSubmenu">
                <nav class="nav flex-column ms-4 small">
                    <a class="nav-link py-1" href="#">Users List</a>
                    <a class="nav-link py-1" href="<?= url('roles') ?>">Roles List</a>
                    <a class="nav-link py-1" href="<?= url('permissions') ?>">Permissions List</a>
                </nav>
            </div>

            <a class="nav-link" data-bs-toggle="collapse" href="#accessSubmenu" role="button">
                <i class="bi bi-shield-lock"></i>
                <span class="sidebar-text">Access Control</span>
                <i class="bi bi-chevron-down ms-auto submenu-arrow small"></i>
            </a>
            <div class="collapse" id="accessSubmenu">
                <nav class="nav flex-column ms-4 small">
                    <a class="nav-link py-1" href="<?= url('roles') ?>">Roles</a>
                    <a class="nav-link py-1" href="<?= url('permissions') ?>">Permissions</a>
                </nav>
            </div>

            <div class="sidebar-heading px-4 py-2 mt-3 small text-uppercase opacity-50 sidebar-text">Modules</div>
            
            <a href="#" class="nav-link">
                <i class="bi bi-cash-stack"></i>
                <span class="sidebar-text">Donations</span>
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-megaphone"></i>
                <span class="sidebar-text">Campaigns</span>
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-person-heart"></i>
                <span class="sidebar-text">Donors</span>
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-cart-dash"></i>
                <span class="sidebar-text">Expenses</span>
            </a>

            <div class="sidebar-heading px-4 py-2 mt-3 small text-uppercase opacity-50 sidebar-text">System</div>
            
            <a href="#" class="nav-link">
                <i class="bi bi-graph-up"></i>
                <span class="sidebar-text">Reports</span>
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-gear"></i>
                <span class="sidebar-text">Settings</span>
            </a>
        </nav>
    </div>
</aside>

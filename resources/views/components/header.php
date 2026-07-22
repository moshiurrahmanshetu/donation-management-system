<header id="header" class="d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <button id="sidebarToggle" class="btn btn-link text-dark me-3">
            <i class="bi bi-list fs-4"></i>
        </button>
        <form class="d-none d-md-flex">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search">
                <button class="btn btn-primary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="d-flex align-items-center gap-3">
        <!-- Theme Toggle -->
        <div id="themeToggle" class="theme-toggle">
            <i class="bi bi-moon"></i>
        </div>

        <!-- Fullscreen Toggle -->
        <div id="fullscreenToggle" class="theme-toggle d-none d-md-block">
            <i class="bi bi-arrows-fullscreen"></i>
        </div>

        <!-- Notifications -->
        <div class="dropdown">
            <a class="nav-link dropdown-toggle no-arrow" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-bell fs-5"></i>
                <span class="badge bg-danger badge-counter">3+</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in">
                <h6 class="dropdown-header">Alerts Center</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="me-3">
                        <div class="icon-circle bg-primary text-white p-2 rounded-circle">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2023</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </div>

        <div class="vr mx-2"></div>

        <!-- User Profile -->
        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                <span class="d-none d-lg-inline text-gray-600 small"><?= $_SESSION['username'] ?? 'User' ?></span>
                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name=<?= $_SESSION['username'] ?? 'User' ?>&background=random" width="32">
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in">
                <a class="dropdown-item" href="#">
                    <i class="bi bi-person fa-sm fa-fw me-2 text-gray-400"></i> Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="bi bi-gear fa-sm fa-fw me-2 text-gray-400"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="<?= url('logout') ?>">
                    <i class="bi bi-box-arrow-right fa-sm fa-fw me-2"></i> Logout
                </a>
            </div>
        </div>
    </div>
</header>

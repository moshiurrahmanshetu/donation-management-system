<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
        }
        body {
            background-color: #f8f9fa;
        }
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #fff;
            border-right: 1px solid #dee2e6;
            z-index: 1000;
        }
        #main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }
        .nav-link {
            color: #333;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #f0f7ff;
            color: #0d6efd;
        }
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .stat-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../components/sidebar.php'; ?>

    <main id="main-content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><?= $title ?></h4>
            <div class="dropdown">
                <button class="btn btn-white border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> <?= $user['username'] ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>">Logout</a></li>
                </ul>
            </div>
        </header>

        <?php require_once $viewFile; ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

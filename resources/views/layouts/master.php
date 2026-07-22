<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> - <?= APP_NAME ?></title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <!-- External Libraries (Prepared) -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body>

    <?php require_once __DIR__ . '/../components/sidebar.php'; ?>

    <div id="wrapper">
        <?php require_once __DIR__ . '/../components/header.php'; ?>

        <main id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= url('dashboard') ?>">Home</a></li>
                        <?php if (isset($breadcrumb)): ?>
                            <?php foreach ($breadcrumb as $item): ?>
                                <li class="breadcrumb-item <?= $item['active'] ? 'active' : '' ?>">
                                    <?php if ($item['active']): ?>
                                        <?= $item['name'] ?>
                                    <?php else: ?>
                                        <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ol>
                </nav>

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 mb-0 text-gray-800"><?= $title ?? 'Dashboard' ?></h2>
                    <?php if (isset($header_actions)): ?>
                        <div><?= $header_actions ?></div>
                    <?php endif; ?>
                </div>

                <!-- Flash Messages -->
                <?php require_once __DIR__ . '/../components/alert.php'; ?>

                <!-- Main Content -->
                <?php require_once $viewFile; ?>
            </div>
        </main>

        <?php require_once __DIR__ . '/../components/footer.php'; ?>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?= asset('js/main.js') ?>"></script>

    <?php if (isset($scripts)): ?>
        <?= $scripts ?>
    <?php endif; ?>

</body>
</html>

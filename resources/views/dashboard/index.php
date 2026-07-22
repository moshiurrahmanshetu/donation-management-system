<div class="row">
    <!-- Stat Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= get_total_users() ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Roles</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= get_total_roles() ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shield-check fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Permissions</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= get_total_permissions() ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-key fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">System Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= status_badge('online') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cpu fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Charts Placeholder -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Donation Overview</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="donationChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">System Information</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        PHP Version <span><?= get_php_version() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        MySQL Version <span><?= get_mysql_version() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Server <span class="small text-truncate" style="max-width: 150px;"><?= get_server_info() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Database Status <span><?= status_badge('success') ?></span>
                    </li>
                    <?php $storage = get_storage_status(); ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Storage</span>
                            <span><?= $storage['percent'] ?>%</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $storage['percent'] ?>%"></div>
                        </div>
                        <div class="small text-muted mt-1"><?= $storage['used'] ?> / <?= $storage['total'] ?></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> Add New User</button>
                    <button class="btn btn-outline-success btn-sm"><i class="bi bi-shield-plus me-1"></i> Create Role</button>
                    <button class="btn btn-outline-info btn-sm"><i class="bi bi-file-earmark-arrow-down me-1"></i> Backup Database</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('donationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Donations ($)',
                data: [1200, 1900, 3000, 5000, 2000, 3000],
                borderColor: '#4e73df',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.05)'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>

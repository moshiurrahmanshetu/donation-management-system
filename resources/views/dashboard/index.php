

<div class="row mb-4">
    <div class="col-12">
        <div class="card p-4 border-0 bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Welcome, <?= $user['username'] ?>!</h2>
                    <p class="mb-0 opacity-75">You are logged in as <span class="badge bg-white text-primary"><?= ucfirst($user['role']) ?></span></p>
                </div>
                <div class="text-end">
                    <p class="mb-0 opacity-75">System Status</p>
                    <h5 class="fw-bold"><i class="bi bi-circle-fill text-success me-1 small"></i> <?= $system_status ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($quick_cards as $card): ?>
    <div class="col-md-4 mb-4">
        <div class="card p-4 stat-card">
            <div class="d-flex align-items-center">
                <div class="icon bg-<?= $card['color'] ?> bg-opacity-10 text-<?= $card['color'] ?> me-3">
                    <i class="bi <?= $card['icon'] ?>"></i>
                </div>
                <div>
                    <p class="text-muted mb-0"><?= $card['title'] ?></p>
                    <h3 class="fw-bold mb-0"><?= $card['value'] ?></h3>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-4">Recent Activity</h5>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-clock-history display-4 d-block mb-3 opacity-25"></i>
                <p>No recent activity found.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h5 class="fw-bold mb-4">Quick Actions</h5>
            <div class="d-grid gap-2">
                <button class="btn btn-outline-primary text-start"><i class="bi bi-plus-circle me-2"></i> Add Donation</button>
                <button class="btn btn-outline-success text-start"><i class="bi bi-person-plus me-2"></i> Register Donor</button>
                <button class="btn btn-outline-info text-start"><i class="bi bi-file-earmark-pdf me-2"></i> Export Report</button>
            </div>
        </div>
    </div>
</div>

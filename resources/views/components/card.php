<div class="card shadow mb-4 <?= $class ?? '' ?>">
    <?php if (isset($title)): ?>
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            <?php if (isset($header_actions)): ?>
                <div><?= $header_actions ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="card-body">
        <?= $content ?>
    </div>
    <?php if (isset($footer)): ?>
        <div class="card-footer bg-transparent border-top-0">
            <?= $footer ?>
        </div>
    <?php endif; ?>
</div>

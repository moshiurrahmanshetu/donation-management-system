<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog <?= $size ?? '' ?>">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $content ?>
            </div>
            <?php if (isset($footer)): ?>
                <div class="modal-footer bg-light">
                    <?= $footer ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

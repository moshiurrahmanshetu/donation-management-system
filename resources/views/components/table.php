<div class="table-responsive">
    <table class="table table-bordered table-hover <?= $class ?? '' ?>" id="<?= $id ?? 'dataTable' ?>" width="100%" cellspacing="0">
        <thead class="table-light">
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th><?= $header ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?= $body ?>
        </tbody>
    </table>
</div>

<?php if (isset($datatable) && $datatable): ?>
<script>
$(document).ready(function() {
    $('#<?= $id ?? 'dataTable' ?>').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>
<?php endif; ?>

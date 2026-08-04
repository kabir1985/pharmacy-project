<div class="container-fluid">

    <div class="row">

        <?php foreach ($products as $row): ?>

            <?php
            $qty = (int) $row['quantity_per_pack'];

            for ($i = 1; $i <= $qty; $i++):
            ?>

                <div class="col-md-3 mb-3">

                    <div class="card">

                        <div class="card-body text-center">

                            <strong><?= esc($row['product_name']) ?></strong>

                            <br><br>

                            <img
                                src="data:image/png;base64,<?= $row['barcode_image'] ?>"
                                class="img-fluid">

                            <br>

                            <?= esc($row['barcode'] ?: $row['product_id']) ?>

                        </div>

                    </div>

                </div>

            <?php endfor; ?>

        <?php endforeach; ?>

    </div>

</div>

<script>
window.onload = function() {
    window.print();
};
</script>
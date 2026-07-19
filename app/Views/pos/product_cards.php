<?php foreach ($products as $row): ?>

<div class="col-3 mb-3 text-center">

    <img
        data-stock="<?= $row['total_stock']; ?>"
        data-id="<?= $row['product_id']; ?>"
        src="<?= base_url('/public/uploads/' . $row['product_image']); ?>"
        class="img-thumbnail cart_item_image shadow-sm"
        style="width:100px;height:80px;object-fit:cover;">

    <p class="mt-2 mb-1 fw-semibold"
       style="font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
        <?= esc($row['product_name']); ?>
    </p>

    <p class="text-primary mb-0" style="font-size:11px;font-weight:600;">
        ৳<?= number_format($row['sales_price_for_customer'], 2); ?>
    </p>

    <small class="text-success fw-bold">
        Stock : <?= number_format($row['total_stock'], 2); ?>
    </small>

</div>

<?php endforeach; ?>
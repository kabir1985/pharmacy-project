<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="card">
    <div class="card-header">
        <h5>Opening Stock Entry</h5>
    </div>

    <div class="card-body">

        <form method="post" action="<?= base_url('opening-stock/store') ?>">

            <?= csrf_field() ?>

            <div class="row">


                <!-- Product -->
                <div class="col-md-6 mb-3">

                    <label>Product</label>

                    <select name="product_id" 
                            class="form-control select2"
                            required>

                        <option value="">
                            Select Product
                        </option>

                        <?php foreach($products as $product): ?>

                        <option value="<?= $product['product_id'] ?>">
                            <?= $product['product_name'] ?>
                        </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Batch -->
                <div class="col-md-3 mb-3">

                    <label>Batch No</label>

                    <input type="text"
                           name="batch_no"
                           class="form-control">

                </div>



                <!-- Stock Date -->
                <div class="col-md-3 mb-3">

                    <label>Stock Date</label>

                    <input type="date"
                           name="stock_date"
                           class="form-control"
                           value="<?= date('Y-m-d') ?>"
                           required>

                </div>



                <!-- Manufacture Date -->
                <div class="col-md-3 mb-3">

                    <label>Manufacturing Date</label>

                    <input type="date"
                           name="manufacturing_date"
                           class="form-control">

                </div>



                <!-- Expiry Date -->
                <div class="col-md-3 mb-3">

                    <label>Expiry Date</label>

                    <input type="date"
                           name="expiry_date"
                           class="form-control">

                </div>



                <!-- Quantity -->
                <div class="col-md-3 mb-3">

                    <label>Quantity</label>

                    <input type="number"
                           step="0.01"
                           id="quantity"
                           name="quantity"
                           class="form-control"
                           required>

                </div>



                <!-- Unit Cost -->
                <div class="col-md-3 mb-3">

                    <label>Unit Cost</label>

                    <input type="number"
                           step="0.01"
                           id="unit_cost"
                           name="unit_cost"
                           class="form-control"
                           required>

                </div>



                <!-- Total Cost -->
                <div class="col-md-3 mb-3">

                    <label>Total Cost</label>

                    <input type="number"
                           step="0.01"
                           id="total_cost"
                           name="total_cost"
                           class="form-control"
                           readonly>

                </div>


            </div>


            <button type="submit"
                    class="btn btn-primary">

                Save Opening Stock

            </button>


        </form>


    </div>
</div>


<?php
echo $this->endSection();
?>

<script>

function calculateTotal()
{
    let qty = parseFloat(
        document.getElementById('quantity').value
    ) || 0;


    let cost = parseFloat(
        document.getElementById('unit_cost').value
    ) || 0;


    document.getElementById('total_cost').value =
        (qty * cost).toFixed(2);

}


document.getElementById('quantity')
.addEventListener('keyup',calculateTotal);


document.getElementById('unit_cost')
.addEventListener('keyup',calculateTotal);


</script>
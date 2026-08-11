<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="app-title">
    <div>
        <h1>
            <i class="fa fa-edit"></i>
            View Stock Adjustment
        </h1>
    </div>

    <a href="<?= site_url('stock-adjustment'); ?>"
       class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i>
        Back
    </a>
</div>


<div class="row">

    <div class="col-md-12">

        <div class="tile">

            <div class="tile-title-w-btn">
                <h3 class="title">
                    Stock Adjustment
                </h3>
            </div>


            <div class="tile-body">

                <form method="post"
                      action="<?//= site_url( 'stock-adjustment/update/' .  $adjustment['adjustment_id']); ?>">

                    <?= csrf_field(); ?>


                    <div class="form-row">

                        <!-- Adjustment No -->
                        <div class="form-group col-md-4">

                            <label>
                                Adjustment No
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="<?= esc(
                                       $adjustment['adjustment_no']
                                   ); ?>"
                                   readonly>

                        </div>


                        <!-- Date -->
                        <div class="form-group col-md-4">

                            <label>
                                Adjustment Date
                            </label>

                            <input type="date"
                                   name="adjustment_date"
                                   class="form-control"
                                   value="<?= esc(
                                       $adjustment['adjustment_date']
                                   ); ?>"
                                   required>

                        </div>


                        <!-- Type -->
                        <div class="form-group col-md-4">

                            <label>
                                Adjustment Type
                            </label>

                            <select name="adjustment_type"
                                    id="adjustment_type"
                                    class="form-control"
                                    required>

                                <option value="stock_in"
                                    <?= $adjustment['adjustment_type'] === 'stock_in'
                                        ? 'selected'
                                        : ''; ?>>
                                    Stock In
                                </option>

                                <option value="stock_out"
                                    <?= $adjustment['adjustment_type'] === 'stock_out'
                                        ? 'selected'
                                        : ''; ?>>
                                    Stock Out
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="form-row">

                        <!-- Product -->
                        <div class="form-group col-md-6">

                            <label>
                                Product
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="<?= esc(
                                       $adjustment['product_name']
                                   ); ?>"
                                   readonly>

                            <input type="hidden"
                                   name="product_id"
                                   value="<?= esc(
                                       $adjustment['product_id']
                                   ); ?>">

                        </div>


                        <!-- Adjustment Qty -->
                        <div class="form-group col-md-6">

                            <label>
                                Adjustment Quantity
                            </label>

                            <input type="number"
                                   name="adjustment_qty"
                                   class="form-control"
                                   step="0.01"
                                   min="0"
                                   value="<?= esc(
                                       $adjustment['adjustment_qty']
                                   ); ?>"
                                   required>

                        </div>

                    </div>


                    <div class="form-row">

                        <!-- Reason -->
                        <div class="form-group col-md-6">

                            <label>
                                Reason
                            </label>

                            <select name="reason"
                                    class="form-control">

                                <option value="">
                                    Select Reason
                                </option>

                                <?php
                                $reasons = [
                                    'Expired',
                                    'Damaged',
                                    'Lost',
                                    'Physical Count',
                                    'Stock Correction',
                                    'Supplier Return',
                                    'Other'
                                ];
                                ?>

                                <?php foreach ($reasons as $reason): ?>

                                    <option value="<?= esc($reason); ?>"
                                        <?= $adjustment['reason'] === $reason
                                            ? 'selected'
                                            : ''; ?>>

                                        <?= esc($reason); ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- Reference -->
                        <div class="form-group col-md-6">

                            <label>
                                Reference No
                            </label>

                            <input type="text"
                                   name="reference_no"
                                   class="form-control"
                                   value="<?= esc(
                                       $adjustment['reference_no'] ?? ''
                                   ); ?>">

                        </div>

                    </div>


                    <!-- Remarks -->
                    <div class="form-group">

                        <label>
                            Remarks
                        </label>

                        <textarea name="remarks"
                                  class="form-control"
                                  rows="3"><?= esc(
                                      $adjustment['remarks'] ?? ''
                                  ); ?></textarea>

                    </div>


                    <input type="hidden"
                           name="detail_id"
                           value="<?= esc(
                               $adjustment['detail_id']
                           ); ?>">


                    <div class="text-right">

                        <a href="<?= site_url('stock-adjustment'); ?>"
                           class="btn btn-secondary">

                            <i class="fa fa-times"></i>
                            Cancel

                        </a>

<!-- 
                        <button type="submit"
                                class="btn btn-success">

                            <i class="fa fa-save"></i>
                            Update Adjustment

                        </button> -->

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<?php
echo $this->endSection();
?>
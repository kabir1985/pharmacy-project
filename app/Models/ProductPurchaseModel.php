<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\ProductPurchaseDetailsModel;

class ProductPurchaseModel extends Model
{
protected $table = 'product_purchase';

protected $primaryKey = 'purchase_id';

protected $allowedFields = [
    'purchase_invoice',
    'purchaser_id',
    'payment_type',
    'supplier_id',
    'invoice_total',
    'discount_amount_on_invoice_total',
    'vat_amount_on_invoice_total',
    'invoice_net_total',
    'paid_amount',
    'due_amount',
    'purchase_date',
    'remarks',
    'status'
];

protected $useTimestamps = true;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';




public function createPurchase(array $data)
{
    $db = $this->db;

    $db->transBegin();

    try {

        $purchaseList = $data['purchaseList'];

        $discount_on_total_price = $data['discount_on_total_price'];
        $vat_amt_on_total        = $data['vat_amt_on_total'];
        $supplier_id             = $data['supplier_id'];
        $purchaser_id            = $data['purchaser_id'];

        // Generate Invoice
        $day_no = date('z') + 1;
        $unique_text = substr(md5(microtime(true) . mt_rand()), -5);

        $invoice_id = strtoupper(
            "PUR" . date("y") .
            str_pad($day_no, 3, "0", STR_PAD_LEFT) .
            $unique_text
        );

        $total_purchase_amount = 0;
        $purchase_details = [];

        foreach ($purchaseList as $row) {

            $quantity_per_pack   = (int)$row['quantity_per_pack'];
            $box_quantity        = (int)$row['box_quantity'];
            $base_price_per_unit = (float)$row['base_price'];
            $free_qty            = (int)$row['free_qty'];
            $tax_percentage      = (float)$row['tax_percentage'];
            $discount_percent    = (float)$row['discount_percent'];

            $total_qty  = $quantity_per_pack * $box_quantity;
            $base_total = $total_qty * $base_price_per_unit;

            $vat_amount      = $base_total * ($tax_percentage / 100);
            $discount_amount = $base_total * ($discount_percent / 100);

            $row_total = $base_total + $vat_amount - $discount_amount;

            $total_purchase_amount += $row_total;

            $purchase_details[] = [
                'purchase_invoice_id'          => $invoice_id,
                'product_id'                   => $row['product_id'],
                'quantity_per_pack'            => $quantity_per_pack,
                'box_quantity'                 => $box_quantity,
                'base_price_per_unit'          => $base_price_per_unit,
                'free_qty'                     => $free_qty,
                'product_wise_vat_amount'      => $vat_amount,
                'product_wise_discount_amount' => $discount_amount,
                'purchase_price'               => $row_total,
            ];

            if (!empty($row['tax_id'])) {

                $current_tax = $db->table('tax')
                    ->select('tax_percentage')
                    ->where('tax_id', $row['tax_id'])
                    ->get()
                    ->getRowArray();

                if ($current_tax && $current_tax['tax_percentage'] != $tax_percentage) {

                    $db->table('tax')
                        ->where('tax_id', $row['tax_id'])
                        ->update([
                            'tax_percentage' => $tax_percentage
                        ]);
                }
            }
        }

        $detailModel = new ProductPurchaseDetailsModel();
        $detailModel->insertBatch($purchase_details);

        $net_total = $total_purchase_amount - $discount_on_total_price;
        $net_total += ($net_total * ($vat_amt_on_total / 100));

        $vat_amount_on_total_price = $total_purchase_amount * ($vat_amt_on_total / 100);

        $this->insert([
            'purchase_invoice'                  => $invoice_id,
            'purchaser_id'                      => $purchaser_id,
            'payment_type'                      => 'Cash',
            'supplier_id'                       => $supplier_id,
            'invoice_total'                     => $total_purchase_amount,
            'discount_amount_on_invoice_total'  => $discount_on_total_price,
            'vat_amount_on_invoice_total'       => $vat_amount_on_total_price,
            'invoice_net_total'                 => $net_total,
            'purchase_date'                     => date('Y-m-d H:i:s')
        ]);

        $db->transCommit();

        return [
            'status'     => 'success',
            'message'    => 'Purchase Successful!',
            'invoice_id' => $invoice_id
        ];

    } catch (\Throwable $e) {

        $db->transRollback();

        return [
            'status'  => 'error',
            'message' => $e->getMessage()
        ];
    }
}


}

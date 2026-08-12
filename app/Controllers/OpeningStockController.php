<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\TaxModel;
use App\Models\ProductOpeningStockModel;

class OpeningStockController extends BaseController
{ protected ProductModel $productModel;
    protected SupplierModel $supplierModel;
    protected TaxModel $taxModel;
    protected ProductOpeningStockModel $productOpeningStockModel;
     protected \CodeIgniter\Database\BaseConnection $db;

        public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->supplierModel = new SupplierModel();
        $this->taxModel = new TaxModel();
        $this->productOpeningStockModel = new ProductOpeningStockModel();
        $this->db = \Config\Database::connect();
    }

public function index()
{
    return view('opening_stock/openingStockAdd', [
        'products'  => $this->productModel->getProductsForOpeningStock(),
        'suppliers' => $this->supplierModel->findAll(),
        'tax_show'  => $this->taxModel->findAll(),
    ]);
}



public function store()
{
    if (
        !$this->validate([
            'product_id'                  => 'required|integer',
            'quantity'                    => 'required|decimal|greater_than[0]',
            'purchase_price_without_vat'  => 'required|decimal|greater_than[0]',
            'stock_date'                  => 'required|valid_date',
            'selling_price'               => 'required|decimal|greater_than[0]',
        ])
    ) {
        return redirect()
            ->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $this->db->transBegin();

    try {

        /*
        |--------------------------------------------------------------------------
        | Check Existing Opening Stock
        |--------------------------------------------------------------------------
        | Remove this block if you want to allow multiple opening stock entries
        | for the same product.
        */

        $exists = $this->productOpeningStockModel
            ->where('product_id', $this->request->getPost('product_id'))
            ->countAllResults();

        if ($exists > 0) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Opening stock already exists for this product.');
        }

        /*
        |--------------------------------------------------------------------------
        | Get Form Values
        |--------------------------------------------------------------------------
        */

        $quantity               = (float) $this->request->getPost('quantity');
        $bonusQty               = (float) ($this->request->getPost('bonus_quantity') ?: 0);

        $purchaseWithoutVat     = (float) $this->request->getPost('purchase_price_without_vat');

        $taxType                = $this->request->getPost('tax_type');
        $taxId                  = $this->request->getPost('tax_id') ?: null;

        $taxPercentage          = (float) ($this->request->getPost('tax_percentage') ?: 0);

        /*
        |--------------------------------------------------------------------------
        | VAT Calculation
        |--------------------------------------------------------------------------
        */

        if ($taxType == 'without_tax') {

            $taxAmount = ($purchaseWithoutVat * $taxPercentage) / 100;

            $purchaseWithVat = $purchaseWithoutVat + $taxAmount;

        } else {

            $purchaseWithVat = $purchaseWithoutVat;

            if ($taxPercentage > 0) {

                $taxAmount = $purchaseWithVat -
                    ($purchaseWithVat / (1 + ($taxPercentage / 100)));

            } else {

                $taxAmount = 0;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Quantity & Cost
        |--------------------------------------------------------------------------
        */

        $availableQty = $quantity + $bonusQty;

        // Bonus is free
        $totalCost = $quantity * $purchaseWithVat;

        /*
        |--------------------------------------------------------------------------
        | Opening Stock Insert
        |--------------------------------------------------------------------------
        */

        $data = [

            'product_id' => $this->request->getPost('product_id'),

            'supplier_id' => $this->request->getPost('supplier_id') ?: null,

            'quantity' => $quantity,

            'bonus_quantity' => $bonusQty,

            'tax_type' => $taxType,

            'tax_id' => $taxId,

            'tax_percentage' => $taxPercentage,

            'tax_amount' => round($taxAmount, 2),

            'purchase_price_without_vat' => round($purchaseWithoutVat, 2),

            'purchase_price_with_vat' => round($purchaseWithVat, 2),

           // 'total_cost' => round($totalCost, 2),

            'profit_margin_percent' => (float) ($this->request->getPost('profit_margin_percent') ?: 0),

            'selling_price' => (float) $this->request->getPost('selling_price'),

            'stock_date' => $this->request->getPost('stock_date'),

            'remarks' => $this->request->getPost('remarks'),

            'created_by' => session()->get('user_id'),

            'status' => 'active'

        ];

        $this->productOpeningStockModel->insert($data);

        $openingStockId = $this->productOpeningStockModel->getInsertID();

        /*
        |--------------------------------------------------------------------------
        | Stock Ledger Entry
        |--------------------------------------------------------------------------
        */

        $ledger = [

            'product_id' => $data['product_id'],

            'transaction_type' => 'OPENING',

            'reference_id' => $openingStockId,

            'qty_in' => $availableQty,

            'qty_out' => 0,

            'balance_qty' => $availableQty,

            'unit_cost' => round($purchaseWithVat, 2),

            'transaction_date' => date(
                'Y-m-d H:i:s',
                strtotime($data['stock_date'])
            ),

            'remarks' => 'Opening Stock',

            'created_by' => session()->get('user_id')

        ];

        $this->db->table('stock_ledger')->insert($ledger);

        /*
        |--------------------------------------------------------------------------
        | Transaction Check
        |--------------------------------------------------------------------------
        */

        if ($this->db->transStatus() === false) {

            $this->db->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to save opening stock.');
        }

        $this->db->transCommit();

        return redirect()
            ->to(site_url('opening-stock'))
            ->with('success', 'Opening Stock added successfully.');

    } catch (\Throwable $e) {

        $this->db->transRollback();

        log_message('error', 'Opening Stock Error : ' . $e->getMessage());

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}



}
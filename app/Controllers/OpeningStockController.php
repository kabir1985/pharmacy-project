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
            'products' => $this->productModel->findAll(),
            'suppliers' => $this->supplierModel->findAll(),
            'tax_show' => $this->taxModel->findAll(),
        ]);
    }

    public function store()
    {


// echo "<pre>";
// print_r($this->request->getPost());
// exit;

        if (
            !$this->validate([
                'product_id' => 'required|integer',
                'quantity' => 'required|decimal',
                'purchase_price_without_vat' => 'required|decimal',
                'stock_date' => 'required|valid_date',
            ])
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

       // $db = \Config\Database::connect();

        try {

           // $this->db->transBegin();

            // ===============================
            // Duplicate Batch Check
            // ==

            $exists = $this->db->table('product_opening_stock')
                ->where('product_id', $this->request->getPost('product_id'))
                ->countAllResults();

            if ($exists > 0) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'This batch already exists for the selected product.');
            }

            // ===============================
            // Continue Processing
            // ===============================

            $quantity = (float) $this->request->getPost('quantity');
            $bonusQty = (float) ($this->request->getPost('bonus_quantity') ?? 0);

            $purchaseWithoutVat = (float) $this->request->getPost('purchase_price_without_vat');

            $taxType = $this->request->getPost('tax_type');
            $taxId = $this->request->getPost('tax_id') ?: null;
            $taxPercentage = (float) ($this->request->getPost('tax_percentage') ?? 0);

            $taxAmount = ($purchaseWithoutVat * $taxPercentage) / 100;

            $purchaseWithVat = $purchaseWithoutVat + $taxAmount;

            // Total stock including bonus
            $availableQty = $quantity + $bonusQty;

            $data = [

                'product_id' => $this->request->getPost('product_id'),
                'supplier_id' => $this->request->getPost('supplier_id') ?: null,

                'expiry_date' => $this->request->getPost('expiry_date') ?: null,

                'quantity' => $quantity,
                'bonus_quantity' => $bonusQty,

                'tax_type' => $taxType,
                'tax_id' => $taxId,
                'tax_percentage' => $taxPercentage,
                'tax_amount' => $taxAmount,

                'purchase_price_without_vat' => $purchaseWithoutVat,
                'purchase_price_with_vat' => $purchaseWithVat,

                'profit_margin_percent' => (float) ($this->request->getPost('profit_margin_percent') ?? 0),

                'selling_price' => (float) ($this->request->getPost('selling_price') ?? 0),

                'stock_date' => $this->request->getPost('stock_date'),

                'remarks' => $this->request->getPost('remarks'),

                'created_by' => session()->get('user_id'),

                'status' => 'active',
            ];
 
 $this->productOpeningStockModel->insert($data);

 $openingStockId = $this->productOpeningStockModel->db->insertID();


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

                'unit_cost' => $purchaseWithVat,

                'transaction_date' => $data['stock_date'],

                'remarks' => 'Opening Stock',

                'created_by' => session()->get('user_id'),

            ];

            $this->db->table('stock_ledger')->insert($ledger);

            if (!$this->db->transStatus()) {

                $this->db->transRollback();

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Failed to save opening stock.');
            }

          //  $this->db->transCommit();

            return redirect()
                ->to(site_url('opening-stock'))
                ->with('success', 'Opening Stock added successfully.');

        } catch (\Throwable $e) {

            $this->db->transRollback();

            log_message('error', 'Opening Stock Error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong while saving opening stock.');
        }
    }

}
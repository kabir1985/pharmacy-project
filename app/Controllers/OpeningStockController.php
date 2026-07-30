<?php

namespace App\Controllers;

use App\Models\ProductModel;

class OpeningStockController extends BaseController
{

    public function index()
    {
        $productModel = new ProductModel();

        return view('opening_stock/create', [
            'products' => $productModel->findAll(),
        ]);
    }


    public function store()
    {

        if (!$this->validate([
            'product_id' => 'required',
            'quantity'   => 'required|numeric',
            'unit_cost'  => 'required|numeric',
            'stock_date' => 'required'
        ])) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }


        $db = \Config\Database::connect();


        try {


            $db->transStart();


            $data = [

                'product_id' => $this->request->getPost('product_id'),

                'batch_no' => $this->request->getPost('batch_no'),

                'manufacturing_date' => 
                    $this->request->getPost('manufacturing_date') ?: null,

                'expiry_date' => 
                    $this->request->getPost('expiry_date') ?: null,

                'quantity' => 
                    $this->request->getPost('quantity'),

                'unit_cost' => 
                    $this->request->getPost('unit_cost'),

                'total_cost' => 
                    $this->request->getPost('total_cost'),

                'stock_date' => 
                    $this->request->getPost('stock_date'),

                'created_by' => 
                    session()->get('user_id'),

            ];


            // Insert Opening Stock

            $db->table('product_opening_stock')
                ->insert($data);


            $openingStockId = $db->insertID();



            // Insert Stock Ledger

            $ledger = [

                'product_id' => $data['product_id'],

                'batch_no' => $data['batch_no'],

                'transaction_type' => 'OPENING',

                'reference_id' => $openingStockId,

                'qty_in' => $data['quantity'],

                'qty_out' => 0,

                'balance_qty' => $data['quantity'],

                'unit_cost' => $data['unit_cost'],

                'transaction_date' => $data['stock_date'],

            ];


            $db->table('stock_ledger')
                ->insert($ledger);


            $db->transComplete();



            if ($db->transStatus()) {

                return redirect()
                    ->to('/opening-stock/create')
                    ->with('success','Opening Stock Added Successfully');

            }


        } catch(\Exception $e) {


            $db->transRollback();


            return redirect()
                ->back()
                ->withInput()
                ->with('error',$e->getMessage());

        }

    }

}
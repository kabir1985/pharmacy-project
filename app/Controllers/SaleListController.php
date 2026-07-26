<?php

namespace App\Controllers;

use App\Models\ProductSaleModel;

class SaleListController extends BaseController
{
    protected $saleModel;

    public function __construct()
    {
        $this->saleModel = new ProductSaleModel();
    }

    public function index()
    {
        $data['saleList'] = $this->saleModel->getSaleList();

        return view('pos/salelistShow', $data);
    }
}
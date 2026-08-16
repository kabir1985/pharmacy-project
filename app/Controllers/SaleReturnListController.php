<?php

namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use App\Models\ReturnSaleModel;

class SaleReturnListController extends BaseController
{
    private $db;
    private $returnSaleModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->returnSaleModel = new ReturnSaleModel();
    }

public function index()
{
    $data['saleReturnList'] = $this->returnSaleModel->getSaleReturnList();

    return view('return/sales_return_list', $data );
}




public function saleReturnListShow()
{
    $data['saleReturnList'] =
        $this->returnSaleModel->saleReturnListShow();

    return view(
        'return/saleReturnListShow',
        $data
    );
}

}

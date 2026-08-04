<?php
namespace App\Controllers;
use App\Models\ReportModel;

class StockReportController extends BaseController
{   
    private $reportModel;
    private $db;
    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->db = db_connect();
    }

    public function index()
{
    $data['stock_report_show'] = $this->reportModel->getStockReport();

    return view('report/stock_report', $data);
}

   

}
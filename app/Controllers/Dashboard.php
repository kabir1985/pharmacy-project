<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class Dashboard extends BaseController
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
        $this->session = Services::session();
    }

    public function index()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        $allowedMenus = $this->session->get('allowedMenus') ?? [];

/////////////////////Today Sale Amount//////////////////////////////////
        $today = date('Y-m-d');

        $today_sales = $this->db->query("
            SELECT IFNULL(SUM(total_amount),0) AS today_sales
            FROM sales
            WHERE DATE(sales_date) = ?
        ", [$today])->getRowArray();
        /////////////////////////////////////////////////////////////////////
        $today_purchase = $this->db->query("
            SELECT IFNULL(SUM(invoice_total),0) AS today_purchase
            FROM product_purchase
            WHERE DATE(purchase_date) = ?
        ", [$today])->getRowArray();

        ///////////////////////////////////////////////////////////////

        return view('ViewDashboard', [
            'allowedMenus' => $allowedMenus,
            'today_sales' => $today_sales['today_sales'],
            'today_purchase' => $today_purchase['today_purchase'],
        ]);
    }
}

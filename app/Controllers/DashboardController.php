<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class DashboardController extends BaseController
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
        // if (!$this->session->get('isLoggedIn')) {
        //     return redirect()->to(site_url('login'));
        // }

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
        // $db = \Config\Database::connect();

        $query = $this->db->query("
          SELECT
            MONTH(sales_date) AS month_no,
            MONTHNAME(sales_date) AS month_name,
            SUM(total_amount) AS total_sale
            FROM sales
            WHERE YEAR(sales_date) = YEAR(CURDATE())
            GROUP BY MONTH(sales_date), MONTHNAME(sales_date)
            ORDER BY month_no
            ");

        $result = $query->getResult();

        $labels = [];
        $amounts = [];

        foreach ($result as $row) {
            $labels[] = $row->month_name;
            $amounts[] = (float) $row->total_sale;
        }

        $data['sales_labels'] = json_encode($labels);
        $data['sales_amounts'] = json_encode($amounts);

//return view('dashboard', $data);

        ///////////////////////////////////////////////////////////////////////////
        $data['allowedMenus'] = $allowedMenus;
        $data['today_sales'] = $today_sales['today_sales'];
        $data['today_purchase'] = $today_purchase['today_purchase'];

        return view('ViewDashboard', $data);

        // return view('ViewDashboard', [
        //     'allowedMenus' => $allowedMenus,
        //     'today_sales' => $today_sales['today_sales'],
        //     'today_purchase' => $today_purchase['today_purchase'],
        //     $data
        // ]);
    }

}
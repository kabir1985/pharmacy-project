<?php
namespace App\Controllers;

class Stockreport extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        $sql = "SELECT
        pis.product_id,
        pis.product_name,
        pis.base_price,
        pis.purchase_price,
        pis.sales_price_for_customer,
        pis.`profit_margin_%` AS profit_margin,
        pis.tax_amount,
        tx.tax_percentage AS tax,
        pis.productinitial_quantity AS initial_stock,
        IFNULL(ppd_data.totalPurchase, 0) AS newPurchase,
        IFNULL(sd_data.totalSale, 0) AS totalSale,
        u.user_name AS purchaser_name,
        (pis.productinitial_quantity + IFNULL(ppd_data.totalPurchase,0) - IFNULL(sd_data.totalSale,0)) AS current_stock
    FROM
        product_inital_stock AS pis
    LEFT JOIN tax AS tx ON pis.tax_id = tx.tax_id
   
    LEFT JOIN (
        SELECT
            ppd.product_id,
            SUM(ppd.quantity_per_pack * ppd.box_quantity) AS totalPurchase,
            MAX(pp.purchaser_id) AS purchaser_id
        FROM
            product_purchase_details AS ppd
        LEFT JOIN product_purchase AS pp
            ON ppd.purchase_invoice_id = pp.purchase_invoice
        GROUP BY ppd.product_id
    ) AS ppd_data
        ON pis.product_id = ppd_data.product_id
   
    LEFT JOIN (
        SELECT
            sd.product_id,
            SUM(sd.product_quantity_sold) AS totalSale
        FROM
            sales_details AS sd
        GROUP BY sd.product_id
    ) AS sd_data
        ON sd_data.product_id = pis.product_id
    LEFT JOIN user AS u
        ON u.user_id = ppd_data.purchaser_id";

        $data['stock_report_show'] = $this->db->query($sql)->getResult('array');
        return view('report/stock_report', $data);
    }

}
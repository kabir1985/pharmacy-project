<?php
namespace App\Controllers;
use CodeIgniter\HTTP\IncomingRequest;
class Stockreport extends BaseController
{
   private $db;
   public function __construct()
   {
      $this->db = db_connect();
   }

   public function index()
   {
      // $sql = "SELECT  pis.product_id, pis.product_name, pis.buying_unit_price AS buyingPrice,
      //         pis.selling_unit_price AS sellingPrice, pis.tax_perchantage AS tAX,
      //         pis.productinitial_quantity AS initial_stock,
      //         IFNULL(ppd.totalPurchase,0) AS newPurchase,
      //         IFNULL(sd.totalSale,0) AS TotalSale
      // FROM product_inital_stock AS pis
      //    LEFT JOIN 
      //    (
      //       SELECT ppd.product_id, SUM(ppd.quantity) AS totalPurchase
      //       FROM  product_purchase_details AS ppd
      //       GROUP BY ppd.product_id
      //    ) AS ppd ON pis.product_id = ppd.product_id
         
      //    LEFT JOIN
      //    (
      //       SELECT  sd.product_id, SUM(sd.product_quantity_sold) AS totalSale
      //       FROM    sales_details AS sd
      //       GROUP BY sd.product_id
      //    ) AS sd ON sd.product_id = pis.product_id";

$sql = "SELECT  
    pis.product_id, 
    pis.product_name, 
    pis.base_price,
    pis.purchase_price ,
    pis.sales_price,
    pis.profit_margin,
    pis.tax_amount,
    tx.tax_percentage AS tAX,
    -- pis.tax_perchantage AS tAX,
    pis.productinitial_quantity AS initial_stock,
    IFNULL(ppd_data.totalPurchase, 0) AS newPurchase,
    IFNULL(sd_data.totalSale, 0) AS TotalSale,
    u.user_name AS purchaser_name  -- ✅ Added purchaser name
FROM 
    product_inital_stock AS pis

    LEFT JOIN tax as tx  ON pis.tax_id = tx.tax_id 
    
LEFT JOIN 
    (
        SELECT 
            ppd.product_id, 
            SUM(ppd.quantity_per_pack * box_quantity) AS totalPurchase,
            MAX(pp.purchaser_id) AS purchaser_id  -- ✅ Representative purchaser (if multiple purchases)
        FROM  
            product_purchase_details AS ppd
        LEFT JOIN product_purchase AS pp 
            ON ppd.purchase_invoice_id = pp.purchase_invoice
        GROUP BY 
            ppd.product_id
    ) AS ppd_data 
    ON pis.product_id = ppd_data.product_id

 

LEFT JOIN
    (
        SELECT  
            sd.product_id, 
            SUM(sd.product_quantity_sold) AS totalSale
        FROM    
            sales_details AS sd
        GROUP BY 
            sd.product_id
    ) AS sd_data 
    ON sd_data.product_id = pis.product_id
LEFT JOIN 
    user AS u 
    ON u.user_id = ppd_data.purchaser_id";

      
      $data['stock_report_show'] = $this->db->query($sql)->getResult('array');
      return view('report/stock_report', $data);
   }

}

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
    
            IFNULL(ppd_data.totalPurchase,0) AS newPurchase,
    
            IFNULL(rs_data.totalReturn,0) AS totalReturn,
    
            IFNULL(adj.totalStockIn,0) AS stockIn,
    
            IFNULL(adj.totalStockOut,0) AS stockOut,
    
            IFNULL(sd_data.totalSale,0) AS totalSale,
    
            u.user_name AS purchaser_name,
    
            GREATEST(
                pis.productinitial_quantity
                + IFNULL(ppd_data.totalPurchase,0)
                + IFNULL(rs_data.totalReturn,0)
                + IFNULL(adj.totalStockIn,0)
                - IFNULL(sd_data.totalSale,0)
                - IFNULL(adj.totalStockOut,0)
            ,0) AS current_stock
    
        FROM product_inital_stock AS pis
    
        LEFT JOIN tax tx
            ON pis.tax_id = tx.tax_id
    
        -- ================= PURCHASE =================
        LEFT JOIN
        (
            SELECT
    
                ppd.product_id,
    
                SUM(
                    (IFNULL(ppd.quantity_per_pack,0) * IFNULL(ppd.box_quantity,1))
                    + IFNULL(ppd.free_qty,0)
                ) AS totalPurchase,
    
                MAX(pp.purchaser_id) AS purchaser_id
    
            FROM product_purchase_details ppd
    
            LEFT JOIN product_purchase pp
                ON pp.purchase_invoice = ppd.purchase_invoice_id
    
            GROUP BY ppd.product_id
    
        ) ppd_data
            ON pis.product_id = ppd_data.product_id
    
        -- ================= SALES =================
        LEFT JOIN
        (
            SELECT
                product_id,
                SUM(product_quantity_sold) AS totalSale
    
            FROM sales_details
    
            GROUP BY product_id
    
        ) sd_data
            ON pis.product_id = sd_data.product_id
    
        -- ================= SALES RETURN =================
        LEFT JOIN
        (
            SELECT
                product_id,
                SUM(return_qty) AS totalReturn
    
            FROM return_sales_details
    
            GROUP BY product_id
    
        ) rs_data
            ON pis.product_id = rs_data.product_id
    
        -- ================= STOCK ADJUSTMENT =================
        LEFT JOIN
        (
            SELECT
    
                sad.product_id,
    
                SUM(
                    CASE
                        WHEN sa.adjustment_type='stock_in'
                        THEN sad.adjustment_qty
                        ELSE 0
                    END
                ) AS totalStockIn,
    
                SUM(
                    CASE
                        WHEN sa.adjustment_type='stock_out'
                        THEN sad.adjustment_qty
                        ELSE 0
                    END
                ) AS totalStockOut
    
            FROM stock_adjustment_details sad
    
            INNER JOIN stock_adjustment sa
                ON sa.adjustment_id = sad.adjustment_id
    
            /* Uncomment if using approval
            WHERE sa.status='Approved'
            */
    
            GROUP BY sad.product_id
    
        ) adj
            ON pis.product_id = adj.product_id
    
        LEFT JOIN user u
            ON u.user_id = ppd_data.purchaser_id
    
        ORDER BY pis.product_name ASC";
    
        $data['stock_report_show'] = $this->db->query($sql)->getResultArray();
    
        return view('report/stock_report', $data);
    }

}
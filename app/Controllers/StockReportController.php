<?php
namespace App\Controllers;

class StockReportController extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        $sql = "SELECT
    p.product_id,
    p.product_name,

    pc.category_name,
    pb.product_brand_name,
    pg.group_name,
    pu.product_unit_name,

    os.purchase_price_with_vat AS purchase_price,
    os.selling_price,
    os.tax_percentage,
    os.profit_margin_percent,

    COALESCE(opening.qty,0)          AS opening_stock,
    COALESCE(purchase.qty,0)         AS purchase_stock,
    COALESCE(sale.qty,0)             AS sale_stock,
    COALESCE(sale_return.qty,0)      AS sale_return_stock,
    COALESCE(stock_in.qty,0)         AS stock_in,
    COALESCE(stock_out.qty,0)        AS stock_out,
    COALESCE(ledger.current_stock,0) AS current_stock,
    COALESCE(purchase_return.qty,0) AS purchase_return_stock

FROM products p

LEFT JOIN product_category pc
ON pc.product_category_id=p.product_category

LEFT JOIN product_brand pb
ON pb.brand_id=p.product_brand

LEFT JOIN product_group pg
ON pg.product_group_id=p.product_group

LEFT JOIN product_unit pu
ON pu.product_unit_id=p.product_unit

LEFT JOIN product_opening_stock os
ON os.product_id=p.product_id


LEFT JOIN
(
    SELECT product_id,SUM(qty_in) qty
    FROM stock_ledger
    WHERE transaction_type='OPENING'
    GROUP BY product_id
) opening
ON opening.product_id=p.product_id


LEFT JOIN
(
    SELECT product_id,SUM(qty_in) qty
    FROM stock_ledger
    WHERE transaction_type='PURCHASE'
    GROUP BY product_id
) purchase
ON purchase.product_id=p.product_id


LEFT JOIN
(
    SELECT product_id,SUM(qty_out) qty
    FROM stock_ledger
    WHERE transaction_type='SALE'
    GROUP BY product_id
) sale
ON sale.product_id=p.product_id


LEFT JOIN
(
    SELECT product_id,SUM(qty_in) qty
    FROM stock_ledger
    WHERE transaction_type='SALE_RETURN'
    GROUP BY product_id
) sale_return
ON sale_return.product_id=p.product_id


LEFT JOIN
(
    SELECT product_id,SUM(qty_in) qty
    FROM stock_ledger
    WHERE transaction_type='STOCK_IN'
    GROUP BY product_id
) stock_in
ON stock_in.product_id=p.product_id


LEFT JOIN
(
    SELECT
        product_id,
        SUM(qty_out) AS qty
    FROM stock_ledger
    WHERE transaction_type='PURCHASE_RETURN'
    GROUP BY product_id
) purchase_return
ON purchase_return.product_id = p.product_id



LEFT JOIN
(
    SELECT product_id,SUM(qty_out) qty
    FROM stock_ledger
    WHERE transaction_type='STOCK_OUT'
    GROUP BY product_id
) stock_out
ON stock_out.product_id=p.product_id


LEFT JOIN
(
    SELECT
        product_id,
        SUM(qty_in-qty_out) AS current_stock
    FROM stock_ledger
    GROUP BY product_id
) ledger
ON ledger.product_id=p.product_id

ORDER BY p.product_name";

        $data['stock_report_show'] = $this->db
            ->query($sql)
            ->getResultArray();

        return view('report/stock_report', $data);
    }

}
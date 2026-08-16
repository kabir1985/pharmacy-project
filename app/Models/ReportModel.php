<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $DBGroup = 'default';

  public function getStockReport()
{
    $sql = "SELECT

        /* =====================================================
           PRODUCT
        ===================================================== */

        p.product_id,
        p.product_name,

        pc.category_name,
        pb.product_brand_name,
        pg.group_name,
        pu.product_unit_name,


        /* =====================================================
           PURCHASE PRICE

           Priority:
           1. Opening Stock
           2. Latest Purchase
        ===================================================== */

        COALESCE(
            NULLIF(os.purchase_price_with_vat, 0),
            NULLIF(lp.purchase_price, 0),
            0
        ) AS purchase_price,


        /* =====================================================
           SELLING UNIT PRICE

           Priority:
           1. Opening Stock
           2. Latest Purchase
        ===================================================== */

        COALESCE(
            NULLIF(os.selling_unit_price, 0),
            NULLIF(lp.selling_unit_price, 0),
            0
        ) AS selling_price,


        /* =====================================================
           TAX
        ===================================================== */

        COALESCE(
            os.tax_percentage,
            lp.tax_percentage,
            0
        ) AS tax_percentage,


        /* =====================================================
           PROFIT MARGIN
        ===================================================== */

        COALESCE(
            os.profit_margin_percent,
            0
        ) AS profit_margin_percent,


        /* =====================================================
           PACK INFORMATION
        ===================================================== */

        COALESCE(
            NULLIF(lp.quantity_per_pack, 0),
            1
        ) AS quantity_per_pack,

        COALESCE(
            NULLIF(lp.box_quantity, 0),
            1
        ) AS box_quantity,


        /* =====================================================
           OPENING STOCK
        ===================================================== */

        COALESCE(
            opening.qty,
            0
        ) AS opening_stock,


        /* =====================================================
           PURCHASE STOCK
        ===================================================== */

        COALESCE(
            purchase.qty,
            0
        ) AS purchase_stock,


        /* =====================================================
           SALE STOCK
        ===================================================== */

        COALESCE(
            sale.qty,
            0
        ) AS sale_stock,


        /* =====================================================
           SALE RETURN
        ===================================================== */

        COALESCE(
            sale_return.qty,
            0
        ) AS sale_return_stock,


        /* =====================================================
           STOCK IN
        ===================================================== */

        COALESCE(
            stock_in.qty,
            0
        ) AS stock_in,


        /* =====================================================
           STOCK OUT
        ===================================================== */

        COALESCE(
            stock_out.qty,
            0
        ) AS stock_out,


        /* =====================================================
           PURCHASE RETURN
        ===================================================== */

        COALESCE(
            purchase_return.qty,
            0
        ) AS purchase_return_stock,


        /* =====================================================
           CURRENT STOCK

           SUM(qty_in - qty_out)
        ===================================================== */

        COALESCE(
            ledger.current_stock,
            0
        ) AS current_stock


    FROM products p


    /* =========================================================
       CATEGORY
       ========================================================= */

    LEFT JOIN product_category pc
        ON pc.product_category_id =
           p.product_category


    /* =========================================================
       BRAND
       ========================================================= */

    LEFT JOIN product_brand pb
        ON pb.brand_id =
           p.product_brand


    /* =========================================================
       GROUP
       ========================================================= */

    LEFT JOIN product_group pg
        ON pg.product_group_id =
           p.product_group


    /* =========================================================
       UNIT
       ========================================================= */

    LEFT JOIN product_unit pu
        ON pu.product_unit_id =
           p.product_unit


    /* =========================================================
       LATEST ACTIVE OPENING STOCK

       Only one opening-stock record per product.
       ========================================================= */

    LEFT JOIN (
        SELECT os1.*

        FROM product_opening_stock os1

        INNER JOIN (
            SELECT
                product_id,
                MAX(opening_stock_id)
                    AS latest_opening_stock_id

            FROM product_opening_stock

            WHERE status = 'active'

            GROUP BY product_id

        ) os2

            ON os2.latest_opening_stock_id =
               os1.opening_stock_id

    ) os

        ON os.product_id =
           p.product_id


    /* =========================================================
       LATEST ACTIVE PURCHASE

       Only the latest purchase detail per product.
       ========================================================= */

    LEFT JOIN (
        SELECT
            ppd.*

        FROM product_purchase_details ppd

        INNER JOIN (
            SELECT

                ppd2.product_id,

                MAX(
                    ppd2.purchase_details_id
                ) AS latest_purchase_details_id

            FROM product_purchase_details ppd2

            INNER JOIN product_purchase pp2

                ON pp2.purchase_id =
                   ppd2.purchase_id

            WHERE pp2.status = 'active'

            GROUP BY ppd2.product_id

        ) latest

            ON latest.latest_purchase_details_id =
               ppd.purchase_details_id

    ) lp

        ON lp.product_id =
           p.product_id


    /* =========================================================
       OPENING STOCK MOVEMENT
       ========================================================= */

    LEFT JOIN (
        SELECT
            product_id,
            SUM(
                COALESCE(qty_in, 0)
            ) AS qty

        FROM stock_ledger

        WHERE transaction_type = 'OPENING'

        GROUP BY product_id

    ) opening

        ON opening.product_id =
           p.product_id


    /* =========================================================
       PURCHASE STOCK
       ========================================================= */

    LEFT JOIN (
        SELECT
            product_id,
            SUM(
                COALESCE(qty_in, 0)
            ) AS qty

        FROM stock_ledger

        WHERE transaction_type = 'PURCHASE'

        GROUP BY product_id

    ) purchase

        ON purchase.product_id =
           p.product_id


    /* =========================================================
       SALE STOCK
       ========================================================= */

    LEFT JOIN (
        SELECT
            product_id,
            SUM(
                COALESCE(qty_out, 0)
            ) AS qty

        FROM stock_ledger

        WHERE transaction_type = 'SALE'

        GROUP BY product_id

    ) sale

        ON sale.product_id =
           p.product_id


    /* =========================================================
       SALE RETURN
       ========================================================= */

    LEFT JOIN (
        SELECT
            product_id,
            SUM(
                COALESCE(qty_in, 0)
            ) AS qty

        FROM stock_ledger

        WHERE transaction_type = 'SALE_RETURN'

        GROUP BY product_id

    ) sale_return

        ON sale_return.product_id =
           p.product_id


    /* =========================================================
       STOCK IN
       ========================================================= */

    LEFT JOIN (
        SELECT
            product_id,
            SUM(
                COALESCE(qty_in, 0)
            ) AS qty

        FROM stock_ledger

        WHERE transaction_type = 'STOCK_IN'

        GROUP BY product_id

    ) stock_in

        ON stock_in.product_id =
           p.product_id


    /* =========================================================
       STOCK OUT
       ========================================================= */

    LEFT JOIN (
        SELECT
            product_id,
            SUM(
                COALESCE(qty_out, 0)
            ) AS qty

        FROM stock_ledger

        WHERE transaction_type = 'STOCK_OUT'

        GROUP BY product_id

    ) stock_out

        ON stock_out.product_id =
           p.product_id


    /* =========================================================
       PURCHASE RETURN
       ========================================================= */

    LEFT JOIN (
        SELECT
            product_id,
            SUM(
                COALESCE(qty_out, 0)
            ) AS qty

        FROM stock_ledger

        WHERE transaction_type = 'PURCHASE_RETURN'

        GROUP BY product_id

    ) purchase_return

        ON purchase_return.product_id =
           p.product_id


    /* =========================================================
       CURRENT STOCK
       ========================================================= */

    LEFT JOIN (
        SELECT

            product_id,

            SUM(
                COALESCE(qty_in, 0)
                -
                COALESCE(qty_out, 0)
            ) AS current_stock

        FROM stock_ledger

        GROUP BY product_id

    ) ledger

        ON ledger.product_id =
           p.product_id


    /* =========================================================
       ACTIVE PRODUCTS ONLY
       ========================================================= */

    WHERE p.status = 'active'


    /* =========================================================
       ORDER
       ========================================================= */

    ORDER BY
        p.product_name ASC";


    return $this->db
        ->query($sql)
        ->getResultArray();
}
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
protected $table = 'products';

protected $primaryKey = 'product_id';

protected $allowedFields = [

    // Product Information
    'product_name',
    'product_category',
    'product_brand',
    'product_group',
    'product_strength',
    'product_unit',
    // Inventory
    'sku',
    'barcode',
    'alert_quantity',

    // Image
    'product_image',
    'status'
];



public function getProducts($category = null)
{
    $builder = $this->db->table('products p');

    $builder->select("
        p.product_id,
        p.product_name,
        p.product_image,
        p.barcode,
        p.alert_quantity,

        pc.category_name,

        /* =========================================
           PURCHASE PRICE
           Opening stock first,
           Latest purchase as fallback
        ========================================= */

        COALESCE(
            pos.purchase_price_without_vat,
            lp.base_price_per_unit,
            0
        ) AS purchase_price_without_vat,

        COALESCE(
            pos.purchase_price_with_vat,
            lp.purchase_price,
            0
        ) AS purchase_price_with_vat,


        /* =========================================
           TAX
        ========================================= */

        COALESCE(
            pos.tax_type,
            CASE
                WHEN lp.tax_percentage > 0
                THEN 'with_tax'
                ELSE 'without_tax'
            END,
            'without_tax'
        ) AS tax_type,

        COALESCE(
            pos.tax_id,
            lp.tax_id
        ) AS tax_id,

        COALESCE(
            pos.tax_percentage,
            lp.tax_percentage,
            0
        ) AS tax_percentage,

        COALESCE(
            pos.tax_amount,
            lp.product_wise_vat_amount,
            0
        ) AS tax_amount,


        /* =========================================
           PROFIT MARGIN
        ========================================= */

        COALESCE(
            pos.profit_margin_percent,

            CASE
                WHEN lp.purchase_price > 0
                THEN (
                    (lp.selling_price - lp.purchase_price)
                    / lp.purchase_price
                ) * 100
                ELSE 0
            END,

            0
        ) AS profit_margin_percent,


        /* =========================================
           FULL SELLING PRICE
        ========================================= */

        COALESCE(
            NULLIF(pos.selling_price, 0),
            NULLIF(lp.selling_price, 0),
            0
        ) AS selling_price,


        /* =========================================
           PACK / UNIT INFORMATION
        ========================================= */

        COALESCE(
            lp.quantity_per_pack,
            1
        ) AS quantity_per_pack,

        COALESCE(
            lp.box_quantity,
            1
        ) AS box_quantity,


        /* =========================================
           SELLING UNIT PRICE

           selling_price
           -------------------------------
           box_quantity × quantity_per_pack
        ========================================= */

      (
    COALESCE(
        NULLIF(pos.selling_price, 0),
        NULLIF(lp.selling_price, 0),
        0
    )
    /
    NULLIF(
        (
            COALESCE(lp.box_quantity, 1)
            *
            COALESCE(lp.quantity_per_pack, 1)
        ),
        0
    )
) AS selling_unit_price,


        /* =========================================
           CURRENT STOCK
        ========================================= */

        COALESCE(
            sl.total_stock,
            0
        ) AS total_stock

    ", false);


    // =====================================================
    // CATEGORY
    // =====================================================

    $builder->join(
        'product_category pc',
        'pc.product_category_id = p.product_category',
        'left'
    );


    // =====================================================
    // OPENING STOCK
    // =====================================================

    $builder->join(
        'product_opening_stock pos',
        'pos.product_id = p.product_id
         AND pos.status = "active"',
        'left',
        false
    );


    // =====================================================
    // LATEST ACTIVE PURCHASE
    // =====================================================

    $builder->join(
        '(
            SELECT ppd.*
            FROM product_purchase_details ppd

            INNER JOIN (
                SELECT
                    ppd2.product_id,
                    MAX(ppd2.purchase_details_id)
                    AS latest_purchase_details_id

                FROM product_purchase_details ppd2

                INNER JOIN product_purchase pp2
                    ON pp2.purchase_id = ppd2.purchase_id

                WHERE pp2.status = "active"

                GROUP BY ppd2.product_id

            ) latest
                ON latest.latest_purchase_details_id =
                   ppd.purchase_details_id

        ) lp',

        'lp.product_id = p.product_id',

        'left',

        false
    );


    // =====================================================
    // CURRENT STOCK
    // =====================================================

    $builder->join(
        '(
            SELECT
                product_id,

                SUM(
                    COALESCE(qty_in, 0)
                    -
                    COALESCE(qty_out, 0)
                ) AS total_stock

            FROM stock_ledger

            GROUP BY product_id

        ) sl',

        'sl.product_id = p.product_id',

        'left',

        false
    );


    // =====================================================
    // ONLY ACTIVE PRODUCTS
    // =====================================================

    $builder->where(
        'p.status',
        'active'
    );


    // =====================================================
    // CATEGORY FILTER
    // =====================================================

    if (
        !empty($category)
        &&
        $category !== 'all_category'
    ) {

        $builder->where(
            'p.product_category',
            $category
        );
    }


    // =====================================================
    // ORDER
    // =====================================================

    $builder->orderBy(
        'p.product_name',
        'ASC'
    );


    return $builder
        ->get()
        ->getResultArray();
}


public function getProductList()
{
    $builder = $this->db->table('products pr');

    $builder->select("
        pr.product_id,
        pr.product_name,
        pr.product_category,
        pr.product_brand,
        pr.product_group,
        pr.product_strength,
        pr.product_unit,
        pr.sku,
        pr.barcode,
        pr.alert_quantity,
        pr.product_image,
        pr.status,

        pc.category_name,
        pg.group_name,
        pb.product_brand_name,
        pu.product_unit_name,
        ps.strength_name,

        /* =====================================================
           TAX TYPE
           Opening stock first, otherwise latest purchase
           ===================================================== */
        COALESCE(
            NULLIF(pos.tax_type, ''),
            CASE
                WHEN COALESCE(lp.tax_percentage, 0) > 0
                THEN 'with_tax'
                ELSE 'without_tax'
            END
        ) AS tax_type,

        /* =====================================================
           TAX ID
           ===================================================== */
        COALESCE(
            pos.tax_id,
            lp.tax_id
        ) AS tax_id,

        /* =====================================================
           TAX NAME
           ===================================================== */
        tx.tax_name,

        /* =====================================================
           TAX PERCENTAGE
           ===================================================== */
        COALESCE(
            pos.tax_percentage,
            lp.tax_percentage,
            0
        ) AS tax_percentage,

        /* =====================================================
           TAX AMOUNT
           ===================================================== */
        COALESCE(
            pos.tax_amount,
            lp.product_wise_vat_amount,
            0
        ) AS tax_amount,

        /* =====================================================
           PURCHASE PRICE WITHOUT VAT
           Opening stock first.
           Latest purchase if opening stock doesn't exist.
           ===================================================== */
        COALESCE(
            NULLIF(pos.purchase_price_without_vat, 0),
            NULLIF(lp.base_price_per_unit, 0),
            0
        ) AS purchase_price_without_vat,

        /* =====================================================
           PURCHASE PRICE WITH VAT
           Opening stock first.
           Latest purchase if opening stock doesn't exist.
           ===================================================== */
        COALESCE(
            NULLIF(pos.purchase_price_with_vat, 0),
            NULLIF(lp.purchase_price, 0),
            0
        ) AS purchase_price_with_vat,

        /* =====================================================
           PROFIT MARGIN
           ===================================================== */
        COALESCE(
            pos.profit_margin_percent,
            0
        ) AS profit_margin_percent,

        /* =====================================================
           SELLING PRICE
           IMPORTANT:
           No hardcoded markup.

           1. Opening stock selling price
           2. Latest purchase selling price
           3. Otherwise 0
           ===================================================== */
        COALESCE(
            NULLIF(pos.selling_price, 0),
            NULLIF(lp.selling_price, 0),
            0
        ) AS selling_price,

        /* =====================================================
           CURRENT STOCK
           ===================================================== */
        COALESCE(
            sl.total_stock,
            0
        ) AS total_stock

    ", false);

    /*
    |--------------------------------------------------------------------------
    | CURRENT STOCK
    |--------------------------------------------------------------------------
    */

    $builder->join(
        "(
            SELECT
                product_id,
                SUM(qty_in - qty_out) AS total_stock
            FROM stock_ledger
            GROUP BY product_id
        ) sl",
        "sl.product_id = pr.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | LATEST ACTIVE OPENING STOCK
    |--------------------------------------------------------------------------
    |
    | Opening stock is optional.
    |
    */

    $builder->join(
        "(
            SELECT os.*
            FROM product_opening_stock os
            INNER JOIN (
                SELECT
                    product_id,
                    MAX(opening_stock_id) AS latest_opening_stock_id
                FROM product_opening_stock
                WHERE status = 'active'
                GROUP BY product_id
            ) x
                ON x.latest_opening_stock_id = os.opening_stock_id
        ) pos",
        "pos.product_id = pr.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | LATEST ACTIVE PURCHASE
    |--------------------------------------------------------------------------
    |
    | This is very important.
    |
    | A newly created product may have:
    |
    | products              = YES
    | opening_stock         = NO
    | purchase              = YES
    |
    | In that case price comes from latest purchase.
    |
    */

    $builder->join(
        "(
            SELECT ppd.*
            FROM product_purchase_details ppd

            INNER JOIN (
                SELECT
                    ppd2.product_id,
                    MAX(ppd2.purchase_details_id) AS latest_purchase_details_id
                FROM product_purchase_details ppd2

                INNER JOIN product_purchase pp2
                    ON pp2.purchase_id = ppd2.purchase_id

                WHERE pp2.status = 'active'

                GROUP BY ppd2.product_id
            ) latest
                ON latest.latest_purchase_details_id = ppd.purchase_details_id

        ) lp",
        "lp.product_id = pr.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | TAX
    |--------------------------------------------------------------------------
    |
    | Opening stock tax first.
    | Otherwise latest purchase tax.
    |
    */

    $builder->join(
        'tax tx',
        'tx.tax_id = COALESCE(pos.tax_id, lp.tax_id)',
        'left',
        false
    );

    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_category pc',
        'pc.product_category_id = pr.product_category',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | GROUP
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_group pg',
        'pg.product_group_id = pr.product_group',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | BRAND
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_brand pb',
        'pb.brand_id = pr.product_brand',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | UNIT
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_unit pu',
        'pu.product_unit_id = pr.product_unit',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | STRENGTH
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_strength ps',
        'ps.strength_id = pr.product_strength',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | ACTIVE PRODUCTS ONLY
    |--------------------------------------------------------------------------
    */

    $builder->where(
        'pr.status',
        'active'
    );

    /*
    |--------------------------------------------------------------------------
    | ORDER
    |--------------------------------------------------------------------------
    */

    $builder->orderBy(
        'pr.product_name',
        'ASC'
    );

    return $builder
        ->get()
        ->getResultArray();
}



public function searchProducts($search)
{
    $builder = $this->db->table('products p');

    $builder->select("
        p.product_id AS id,
        p.product_name AS name,

        CONCAT(
            p.product_name,
            ' | ',
            IFNULL(pb.product_brand_name, ''),
            ' | ',
            IFNULL(pc.category_name, ''),
            ' | ',
            IFNULL(pg.group_name, ''),
            ' | Stock: ',
            COALESCE(SUM(sl.qty_in - sl.qty_out), 0)
        ) AS label,

        COALESCE(SUM(sl.qty_in - sl.qty_out), 0) AS total_stock
    ");

    // Stock Ledger
    $builder->join(
        'stock_ledger sl',
        'sl.product_id = p.product_id',
        'left'
    );

    // Brand
    $builder->join(
        'product_brand pb',
        'pb.brand_id = p.product_brand',
        'left'
    );

    // Category
    $builder->join(
        'product_category pc',
        'pc.product_category_id = p.product_category',
        'left'
    );

    // Group
    $builder->join(
        'product_group pg',
        'pg.product_group_id = p.product_group',
        'left'
    );

    // Only Active Products
    $builder->where('p.status', 'active');

    $search = trim($search);

    $builder->groupStart();

    $builder->like('p.product_name', $search);
    $builder->orLike('pb.product_brand_name', $search);
    $builder->orLike('pc.category_name', $search);
    $builder->orLike('pg.group_name', $search);
    $builder->orLike('p.barcode', $search);

    $builder->groupEnd();

    $builder->groupBy([
        'p.product_id',
        'p.product_name',
        'pb.product_brand_name',
        'pc.category_name',
        'pg.group_name',
        'p.barcode'
    ]);

    // Only products having stock
    $builder->having('total_stock >', 0);

    // Search Priority
    $builder->orderBy("
        CASE
            WHEN p.barcode = ".$this->db->escape($search)." THEN 1
            WHEN p.product_name = ".$this->db->escape($search)." THEN 2
            WHEN p.product_name LIKE '%".$this->db->escapeLikeString($search)."%' THEN 3
            WHEN pb.product_brand_name LIKE '".$this->db->escapeLikeString($search)."%' THEN 4
            WHEN pc.category_name LIKE '".$this->db->escapeLikeString($search)."%' THEN 5
            WHEN pg.group_name LIKE '".$this->db->escapeLikeString($search)."%' THEN 6
            ELSE 7
        END
    ", false);

    $builder->orderBy('p.product_name', 'ASC');

    $builder->limit(20);

    return $builder->get()->getResultArray();
}

public function getProductsWithCurrentStock()
{
    $builder = $this->db->table('products pr');

    $builder->select("
        pr.product_id,
        pr.product_name,
        pr.product_category,
        pr.product_brand,
        pr.product_group,
        pr.product_strength,
        pr.product_unit,
        pr.sku,
        pr.barcode,
        pr.alert_quantity,
        pr.product_image,
        pr.status,

        pc.category_name,
        pb.product_brand_name,
        pg.group_name,
        ps.strength_name,

        /* ==============================
           TAX TYPE
           ============================== */

        COALESCE(
            NULLIF(pos.tax_type, ''),
            CASE
                WHEN COALESCE(lp.tax_percentage, 0) > 0
                THEN 'with_tax'
                ELSE 'without_tax'
            END
        ) AS tax_type,

        /* ==============================
           TAX
           ============================== */

        COALESCE(
            pos.tax_id,
            lp.tax_id
        ) AS tax_id,

        tx.tax_name,

        COALESCE(
            pos.tax_percentage,
            lp.tax_percentage,
            0
        ) AS tax_percentage,

        COALESCE(
            pos.tax_amount,
            lp.product_wise_vat_amount,
            0
        ) AS tax_amount,

        /* ==============================
           PURCHASE PRICE WITHOUT VAT
           Opening stock first
           Latest purchase fallback
           ============================== */

        COALESCE(
            NULLIF(pos.purchase_price_without_vat, 0),
            NULLIF(lp.base_price_per_unit, 0),
            0
        ) AS purchase_price_without_vat,

        /* ==============================
           PURCHASE PRICE WITH VAT
           Opening stock first
           Latest purchase fallback
           ============================== */

        COALESCE(
            NULLIF(pos.purchase_price_with_vat, 0),
            NULLIF(lp.purchase_price, 0),
            0
        ) AS purchase_price_with_vat,

        /* ==============================
           PROFIT MARGIN
           ============================== */

        COALESCE(
            NULLIF(pos.profit_margin_percent, 0),
            0
        ) AS profit_margin_percent,

        /* ==============================
           SELLING PRICE
           Purchase form price first
           Opening stock fallback
           ============================== */

        COALESCE(
            NULLIF(lp.selling_price, 0),
            NULLIF(pos.selling_price, 0),
            0
        ) AS selling_price,

        /* ==============================
           CURRENT STOCK
           ============================== */

        COALESCE(
            sl.total_stock,
            0
        ) AS total_stock

    ", false);

    /*
    |--------------------------------------------------------------------------
    | CURRENT STOCK
    |--------------------------------------------------------------------------
    */

    $builder->join(
        "(
            SELECT
                product_id,
                SUM(qty_in - qty_out) AS total_stock
            FROM stock_ledger
            GROUP BY product_id
        ) sl",
        "sl.product_id = pr.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | LATEST ACTIVE OPENING STOCK
    |--------------------------------------------------------------------------
    */

    $builder->join(
        "(
            SELECT os.*
            FROM product_opening_stock os

            INNER JOIN (
                SELECT
                    product_id,
                    MAX(opening_stock_id) AS latest_opening_stock_id

                FROM product_opening_stock

                WHERE status = 'active'

                GROUP BY product_id

            ) x

            ON x.latest_opening_stock_id = os.opening_stock_id

        ) pos",
        "pos.product_id = pr.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | LATEST ACTIVE PURCHASE
    |--------------------------------------------------------------------------
    */

    $builder->join(
        "(
            SELECT ppd.*

            FROM product_purchase_details ppd

            INNER JOIN (
                SELECT
                    ppd2.product_id,
                    MAX(ppd2.purchase_details_id)
                        AS latest_purchase_details_id

                FROM product_purchase_details ppd2

                INNER JOIN product_purchase pp2
                    ON pp2.purchase_id = ppd2.purchase_id

                WHERE pp2.status = 'active'

                GROUP BY ppd2.product_id

            ) latest

            ON latest.latest_purchase_details_id
               = ppd.purchase_details_id

        ) lp",
        "lp.product_id = pr.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | TAX
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'tax tx',
        'tx.tax_id = COALESCE(pos.tax_id, lp.tax_id)',
        'left',
        false
    );

    /*
    |--------------------------------------------------------------------------
    | CATEGORY
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_category pc',
        'pc.product_category_id = pr.product_category',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | BRAND
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_brand pb',
        'pb.brand_id = pr.product_brand',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | GROUP
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_group pg',
        'pg.product_group_id = pr.product_group',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | STRENGTH
    |--------------------------------------------------------------------------
    */

    $builder->join(
        'product_strength ps',
        'ps.strength_id = pr.product_strength',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | ACTIVE PRODUCTS ONLY
    |--------------------------------------------------------------------------
    */

    $builder->where(
        'pr.status',
        'active'
    );

    /*
    |--------------------------------------------------------------------------
    | ORDER
    |--------------------------------------------------------------------------
    */

    $builder->orderBy(
        'pr.product_name',
        'ASC'
    );

    /*
    |--------------------------------------------------------------------------
    | EXECUTE
    |--------------------------------------------------------------------------
    */

    return $builder
        ->get()
        ->getResultArray();
}

public function getProductsForOpeningStock()
{
    return $this->db->table('products p')
        ->select("
            p.product_id,
            p.product_name,
            p.sku,
            p.barcode,

            pc.category_name,
            pb.product_brand_name,
            pg.group_name,
            pu.product_unit_name
        ")
        ->join('product_category pc', 'pc.product_category_id = p.product_category', 'left')
        ->join('product_brand pb', 'pb.brand_id = p.product_brand', 'left')
        ->join('product_group pg', 'pg.product_group_id = p.product_group', 'left')
        ->join('product_unit pu', 'pu.product_unit_id = p.product_unit', 'left')
        ->where('p.status', 'active')
        ->orderBy('p.product_name', 'ASC')
        ->get()
        ->getResultArray();
}





public function getProductsForBarcode(bool $onlyInStock = false): array
{
    $builder = $this->db->table('product_opening_stock pos');

    $builder->select("
        pos.*,
        p.product_name,
        p.product_image,
        p.barcode,
        p.sku,
        COALESCE(sl.total_stock, 0) AS total_stock
    ");

    $builder->join(
        'products p',
        'p.product_id = pos.product_id',
        'inner'
    );

    $builder->join(
        "(
            SELECT
                product_id,
                SUM(qty_in - qty_out) AS total_stock
            FROM stock_ledger
            GROUP BY product_id
        ) sl",
        'sl.product_id = pos.product_id',
        'left',
        false // Prevent escaping subquery
    );

    $builder->where('pos.status', 'active');
    $builder->where('p.status', 'active');

    if ($onlyInStock) {
        $builder->having('total_stock >', 0);
    }

    $builder->orderBy('p.product_name', 'ASC');

    return $builder->get()->getResultArray();
}




}

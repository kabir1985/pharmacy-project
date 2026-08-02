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
    'product_image'
];





    // public function getProducts($category = null)
    // {
    //     $condition = '';

    //     if (!empty($category) && $category !== 'all_category') {
    //         $condition = " WHERE pis.product_category = " . (int) $category;
    //     }

    //     $sql = "SELECT
    //                 pis.product_id,
    //                 pis.product_name,
    //                 pis.product_image,
    //                 pis.sales_price_for_customer,
    //                 pis.purchase_price,

    //                 GREATEST(
    //                     COALESCE(pis.productinitial_quantity,0)
    //                     + COALESCE(ppd.total_purchase_qty,0)
    //                     + COALESCE(rs.total_return,0)
    //                     + COALESCE(adj.total_stock_in,0)
    //                     - COALESCE(sd.total_sale,0)
    //                     - COALESCE(adj.total_stock_out,0)
    //                 ,0) AS total_stock

    //             FROM product_inital_stock pis

    //             LEFT JOIN (
    //                 SELECT
    //                     product_id,
    //                     SUM((IFNULL(quantity_per_pack,0)*IFNULL(box_quantity,0))+IFNULL(free_qty,0)) total_purchase_qty
    //                 FROM product_purchase_details
    //                 GROUP BY product_id
    //             ) ppd
    //             ON ppd.product_id=pis.product_id

    //             LEFT JOIN (
    //                 SELECT
    //                     product_id,
    //                     SUM(product_quantity_sold) total_sale
    //                 FROM sales_details
    //                 GROUP BY product_id
    //             ) sd
    //             ON sd.product_id=pis.product_id

    //             LEFT JOIN (
    //                 SELECT
    //                     product_id,
    //                     SUM(return_qty) total_return
    //                 FROM return_sales_details
    //                 GROUP BY product_id
    //             ) rs
    //             ON rs.product_id=pis.product_id

    //             LEFT JOIN (
    //                 SELECT
    //                     sad.product_id,

    //                     SUM(
    //                         CASE
    //                             WHEN sa.adjustment_type='stock_in'
    //                             THEN sad.adjustment_qty
    //                             ELSE 0
    //                         END
    //                     ) total_stock_in,

    //                     SUM(
    //                         CASE
    //                             WHEN sa.adjustment_type='stock_out'
    //                             THEN sad.adjustment_qty
    //                             ELSE 0
    //                         END
    //                     ) total_stock_out

    //                 FROM stock_adjustment_details sad
    //                 INNER JOIN stock_adjustment sa
    //                 ON sa.adjustment_id=sad.adjustment_id

    //                 GROUP BY sad.product_id

    //             ) adj
    //             ON adj.product_id=pis.product_id

    //             $condition";

    //     return $this->db->query($sql)->getResultArray();
    // }

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

        pos.batch_no,
        pos.purchase_price_without_vat,
        pos.purchase_price_with_vat,
        pos.tax_type,
        pos.tax_id,
        pos.tax_percentage,
        pos.tax_amount,
        pos.profit_margin_percent,
        pos.selling_price,

        COALESCE(SUM(sl.qty_in - sl.qty_out), 0) AS total_stock
    ");

    // Product Category
    $builder->join(
        'product_category pc',
        'pc.product_category_id = p.product_category',
        'left'
    );

    // Active Opening Stock
    $builder->join(
        'product_opening_stock pos',
        'pos.product_id = p.product_id
         AND pos.status = "active"',
        'left'
    );

    // Stock Ledger
    $builder->join(
        'stock_ledger sl',
        'sl.product_id = p.product_id',
        'left'
    );

    // Category Filter
    if (!empty($category) && $category != 'all_category') {
        $builder->where('p.product_category', $category);
    }

    $builder->groupBy([
        'p.product_id',
        'p.product_name',
        'p.product_image',
        'p.barcode',
        'p.alert_quantity',

        'pc.category_name',

        'pos.batch_no',
        'pos.purchase_price_without_vat',
        'pos.purchase_price_with_vat',
        'pos.tax_type',
        'pos.tax_id',
        'pos.tax_percentage',
        'pos.tax_amount',
        'pos.profit_margin_percent',
        'pos.selling_price'
    ]);

    $builder->orderBy('p.product_name', 'ASC');

    return $builder->get()->getResultArray();
}

public function getProductList()
{
    return $this->db->table('products pr')
        ->select("
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

            pos.batch_no,
            pos.quantity,
            pos.bonus_quantity,
            pos.tax_type,
            pos.tax_id,
            pos.tax_percentage,
            pos.tax_amount,
            pos.purchase_price_without_vat,
            pos.purchase_price_with_vat,
            pos.profit_margin_percent,
            pos.selling_price,

            tx.tax_name,

            COALESCE(SUM(sl.qty_in - sl.qty_out), 0) AS total_stock
        ")

        ->join('product_category pc', 'pc.product_category_id = pr.product_category', 'left')
        ->join('product_group pg', 'pg.product_group_id = pr.product_group', 'left')
        ->join('product_brand pb', 'pb.brand_id = pr.product_brand', 'left')
        ->join('product_unit pu', 'pu.product_unit_id = pr.product_unit', 'left')
        ->join('product_strength ps', 'ps.strength_id = pr.product_strength', 'left')

        // Active Opening Stock
        ->join(
            'product_opening_stock pos',
            'pos.product_id = pr.product_id AND pos.status = "active"',
            'left'
        )

        ->join('tax tx', 'tx.tax_id = pos.tax_id', 'left')

        // Stock Ledger
        ->join(
            'stock_ledger sl',
            'sl.product_id = pr.product_id',
            'left'
        )

        ->where('pr.status', 'active')

        ->groupBy([
            'pr.product_id',
            'pr.product_name',
            'pr.product_category',
            'pr.product_brand',
            'pr.product_group',
            'pr.product_strength',
            'pr.product_unit',
            'pr.sku',
            'pr.barcode',
            'pr.alert_quantity',
            'pr.product_image',
            'pr.status',

            'pc.category_name',
            'pg.group_name',
            'pb.product_brand_name',
            'pu.product_unit_name',
            'ps.strength_name',

            'pos.batch_no',
            'pos.quantity',
            'pos.bonus_quantity',
            'pos.tax_type',
            'pos.tax_id',
            'pos.tax_percentage',
            'pos.tax_amount',
            'pos.purchase_price_without_vat',
            'pos.purchase_price_with_vat',
            'pos.profit_margin_percent',
            'pos.selling_price',

            'tx.tax_name'
        ])

        ->orderBy('pr.product_name', 'ASC')

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
            IFNULL(pb.product_brand_name,''),
            ' | ',
            IFNULL(pc.category_name,''),
            ' | ',
            IFNULL(pg.group_name,''),
            ' | Stock: ',
            COALESCE(SUM(sl.qty_in - sl.qty_out),0)
        ) AS label,

        COALESCE(SUM(sl.qty_in - sl.qty_out),0) AS total_stock
    ");

    $builder->join(
        'stock_ledger sl',
        'sl.product_id = p.product_id',
        'left'
    );

    $builder->join(
        'product_brand pb',
        'pb.brand_id = p.product_brand',
        'left'
    );

    $builder->join(
        'product_category pc',
        'pc.product_category_id = p.product_category',
        'left'
    );

    $builder->join(
        'product_group pg',
        'pg.product_group_id = p.product_group',
        'left'
    );

    // Optional: only products having active opening stock
    $builder->join(
        'product_opening_stock pos',
        'pos.product_id = p.product_id AND pos.status = "active"',
        'left'
    );

    // Only Active Products
    $builder->where('p.status', 'active');

    $search = strtolower(trim($search));

    $builder->groupStart();

    $builder->where("
        LOWER(CONCAT(
            p.product_name,' ',
            IFNULL(pb.product_brand_name,''),' ',
            IFNULL(pc.category_name,''),' ',
            IFNULL(pg.group_name,''),' ',
            IFNULL(p.barcode,'')
        )) LIKE '%".$this->db->escapeLikeString($search)."%'
    ", null, false);

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

    $builder->orderBy("
        CASE
            WHEN p.barcode = ".$this->db->escape($search)." THEN 1
            WHEN LOWER(p.product_name) = ".$this->db->escape(strtolower($search))." THEN 2
            WHEN LOWER(p.product_name) LIKE '%".$this->db->escapeLikeString($search)."%' THEN 3
            WHEN LOWER(pb.product_brand_name) LIKE '".$this->db->escapeLikeString($search)."%' THEN 4
            WHEN LOWER(pc.category_name) LIKE '".$this->db->escapeLikeString($search)."%' THEN 5
            WHEN LOWER(pg.group_name) LIKE '".$this->db->escapeLikeString($search)."%' THEN 6
            ELSE 7
        END
    ", false);

    $builder->limit(20);

    return $builder->get()->getResultArray();
}

//In PurchaseController.php, the method getProductsWithCurrentStock() is used 
// to retrieve products along with their current stock levels. 
// It joins multiple tables such as stock_ledger, product_opening_stock, tax, and various 
// product-related tables to gather comprehensive product information. 
// The method filters for active products and groups the results by product attributes to ensure accurate stock calculations.
public function getProductsWithCurrentStock()
{
    $builder = $this->db->table('products p');

    $builder->select("
        p.product_id,
        p.product_name,
        p.product_category,
        p.product_brand,
        p.product_group,
        p.product_strength,
        p.product_unit,
        p.sku,
        p.barcode,
        p.alert_quantity,
        p.product_image,
        p.status,

        pc.category_name,
        pb.product_brand_name,
        pg.group_name,
        ps.strength_name,

        pos.batch_no,
        pos.tax_type,
        pos.tax_id,
        pos.tax_percentage,
        tx.tax_name,
        pos.tax_amount,
        pos.purchase_price_without_vat,
        pos.purchase_price_with_vat,
        pos.profit_margin_percent,
        pos.selling_price
        COALESCE(sl.total_stock,0) AS total_stock
    ");

    // Current Stock
    $builder->join(
        "(
            SELECT
                product_id,
                SUM(qty_in - qty_out) AS total_stock
            FROM stock_ledger
            GROUP BY product_id
        ) sl",
        "sl.product_id = p.product_id",
        "left",
        false
    );

    // Latest Opening Stock (one row per product)
    $builder->join(
        "(
            SELECT os.*
            FROM product_opening_stock os
            INNER JOIN
            (
                SELECT
                    product_id,
                    MAX(opening_stock_id) AS opening_stock_id
                FROM product_opening_stock
                WHERE status='active'
                GROUP BY product_id
            ) x
            ON os.opening_stock_id = x.opening_stock_id
        ) pos",
        "pos.product_id = p.product_id",
        "left",
        false
    );

    // Tax
    $builder->join(
        'tax tx',
        'tx.tax_id = pos.tax_id',
        'left'
    );

    // Masters
    $builder->join(
        'product_category pc',
        'pc.product_category_id = p.product_category',
        'left'
    );

    $builder->join(
        'product_brand pb',
        'pb.brand_id = p.product_brand',
        'left'
    );

    $builder->join(
        'product_group pg',
        'pg.product_group_id = p.product_group',
        'left'
    );

    $builder->join(
        'product_strength ps',
        'ps.strength_id = p.product_strength',
        'left'
    );

    $builder->where('p.status', 'active');

    $builder->orderBy('p.product_name', 'ASC');

    return $builder->get()->getResultArray();
}
}

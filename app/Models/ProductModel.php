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

        pos.purchase_price_without_vat,
        pos.purchase_price_with_vat,
        pos.tax_type,
        pos.tax_id,
        pos.tax_percentage,
        pos.tax_amount,
        pos.profit_margin_percent,
        pos.selling_price,

        COALESCE(sl.total_stock,0) AS total_stock
    ");

    // Category
    $builder->join(
        'product_category pc',
        'pc.product_category_id = p.product_category',
        'left'
    );

    // Active Opening Stock
    $builder->join(
        'product_opening_stock pos',
        'pos.product_id = p.product_id AND pos.status = "active"',
        'left'
    );

    // Current Stock
    $builder->join(
        '(SELECT product_id,
                 SUM(qty_in - qty_out) AS total_stock
          FROM stock_ledger
          GROUP BY product_id) sl',
        'sl.product_id = p.product_id',
        'left',
        false
    );

    if (!empty($category) && $category != 'all_category') {
        $builder->where('p.product_category', $category);
    }

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

        pos.tax_type,
        pos.tax_id,
        pos.tax_percentage,
        tx.tax_name,
        pos.tax_amount,
        pos.purchase_price_without_vat,
        pos.purchase_price_with_vat,
        pos.profit_margin_percent,
        pos.selling_price,

        COALESCE(sl.total_stock, 0) AS total_stock
    ");

    /*
    |--------------------------------------------------------------------------
    | Current Stock (Stock Ledger)
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
        "sl.product_id = p.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | Latest Opening Stock / Pricing
    |--------------------------------------------------------------------------
    */
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
                WHERE status = 'active'
                GROUP BY product_id
            ) x
            ON os.opening_stock_id = x.opening_stock_id
        ) pos",
        "pos.product_id = p.product_id",
        "left",
        false
    );

    /*
    |--------------------------------------------------------------------------
    | Tax
    |--------------------------------------------------------------------------
    */
    $builder->join(
        'tax tx',
        'tx.tax_id = pos.tax_id',
        'left'
    );

    /*
    |--------------------------------------------------------------------------
    | Product Masters
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Only Active Products
    |--------------------------------------------------------------------------
    */
    $builder->where('p.status', 'active');

    $builder->orderBy('p.product_name', 'ASC');

    return $builder->get()->getResultArray();
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

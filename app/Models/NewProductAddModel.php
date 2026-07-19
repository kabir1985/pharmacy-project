<?php

namespace App\Models;

use CodeIgniter\Model;

class NewProductAddModel extends Model
{
    protected $table = 'product_inital_stock';

    protected $primaryKey = 'product_id';

    //protected $allowedFields = ['product_name', 'product_category', 'product_brand', 'product_group', 'product_unit', 'codefor_barcode', 'tax_id', 'productinitial_quantity', 'buying_unit_price', 'selling_unit_price', 'alert_quantity', 'product_image'];

    protected $allowedFields = [
        'product_name', 
        'product_category', 
        'product_brand', 
        'product_group', 
        'product_strength',
        'product_unit', 
        'codefor_barcode', 
        'productinitial_quantity', 
        'base_price',
        'cost_without_vat',  
        'tax_type',  
        'tax_id',    // for tax percentage %         
        'tax_amount', 
        'purchase_price', 
        'profit_margin_%',
        // 'sales_price_before_vat',
        // 'vat_on_sales', 
        'sales_price_for_customer', 
        'alert_quantity', 
        'product_image'
    ];





    public function getProducts($category = null)
    {
        $condition = '';

        if (!empty($category) && $category !== 'all_category') {
            $condition = " WHERE pis.product_category = " . (int) $category;
        }

        $sql = "SELECT
                    pis.product_id,
                    pis.product_name,
                    pis.product_image,
                    pis.sales_price_for_customer,
                    pis.purchase_price,

                    GREATEST(
                        COALESCE(pis.productinitial_quantity,0)
                        + COALESCE(ppd.total_purchase_qty,0)
                        + COALESCE(rs.total_return,0)
                        + COALESCE(adj.total_stock_in,0)
                        - COALESCE(sd.total_sale,0)
                        - COALESCE(adj.total_stock_out,0)
                    ,0) AS total_stock

                FROM product_inital_stock pis

                LEFT JOIN (
                    SELECT
                        product_id,
                        SUM((IFNULL(quantity_per_pack,0)*IFNULL(box_quantity,0))+IFNULL(free_qty,0)) total_purchase_qty
                    FROM product_purchase_details
                    GROUP BY product_id
                ) ppd
                ON ppd.product_id=pis.product_id

                LEFT JOIN (
                    SELECT
                        product_id,
                        SUM(product_quantity_sold) total_sale
                    FROM sales_details
                    GROUP BY product_id
                ) sd
                ON sd.product_id=pis.product_id

                LEFT JOIN (
                    SELECT
                        product_id,
                        SUM(return_qty) total_return
                    FROM return_sales_details
                    GROUP BY product_id
                ) rs
                ON rs.product_id=pis.product_id

                LEFT JOIN (
                    SELECT
                        sad.product_id,

                        SUM(
                            CASE
                                WHEN sa.adjustment_type='stock_in'
                                THEN sad.adjustment_qty
                                ELSE 0
                            END
                        ) total_stock_in,

                        SUM(
                            CASE
                                WHEN sa.adjustment_type='stock_out'
                                THEN sad.adjustment_qty
                                ELSE 0
                            END
                        ) total_stock_out

                    FROM stock_adjustment_details sad
                    INNER JOIN stock_adjustment sa
                    ON sa.adjustment_id=sad.adjustment_id

                    GROUP BY sad.product_id

                ) adj
                ON adj.product_id=pis.product_id

                $condition";

        return $this->db->query($sql)->getResultArray();
    }




    public function getProductList()
{
    return $this->db->table('product_inital_stock AS pr')
        ->select('
            pr.*,
            pc.category_name,
            pg.group_name,
            pb.product_brand_name,
            pu.product_unit_name,
            ps.strength_name,
            tx.tax_name,
            tx.tax_percentage
        ')
        ->join('product_category AS pc', 'pr.product_category = pc.product_category_id', 'left')
        ->join('product_group AS pg', 'pr.product_group = pg.product_group_id', 'left')
        ->join('product_brand AS pb', 'pr.product_brand = pb.brand_id', 'left')
        ->join('product_unit AS pu', 'pr.product_unit = pu.product_unit_id', 'left')
        ->join('product_strength AS ps', 'pr.product_strength = ps.strength_id', 'left')
        ->join('tax AS tx', 'pr.tax_id = tx.tax_id', 'left')
        ->orderBy('pr.product_id', 'DESC')
        ->get()
        ->getResultArray();
}


public function searchProducts($search)
{
    $builder = $this->db->table('product_inital_stock pis');

    $builder->select("
        pis.product_id AS id,
        pis.product_name AS name,

        CONCAT(
            pis.product_name,
            ' | ',
            pb.product_brand_name,
            ' | ',
            pc.category_name,
            ' | ',
            pg.group_name,
            ' | Stock: ',
            (
                COALESCE(pis.productinitial_quantity,0)
                + COALESCE(ppd.new_purchased,0)
                - COALESCE(sd.total_sale,0)
            )
        ) AS label,

        (
            COALESCE(pis.productinitial_quantity,0)
            + COALESCE(ppd.new_purchased,0)
            - COALESCE(sd.total_sale,0)
        ) AS total_stock
    ");

    $builder->join("
        (
            SELECT product_id,
                   SUM(product_quantity_sold) total_sale
            FROM sales_details
            GROUP BY product_id
        ) sd
    ", "pis.product_id=sd.product_id", "left");

    $builder->join("
        (
            SELECT product_id,
                   SUM(quantity_per_pack*box_quantity) new_purchased
            FROM product_purchase_details
            GROUP BY product_id
        ) ppd
    ", "pis.product_id=ppd.product_id", "left");

    $builder->join("product_brand pb", "pb.brand_id=pis.product_brand", "left");
    $builder->join("product_category pc", "pc.product_category_id=pis.product_category", "left");
    $builder->join("product_group pg", "pg.product_group_id=pis.product_group", "left");

    $search = strtolower(trim($search));

    $builder->groupStart();
    $builder->where("
        LOWER(CONCAT(
            pis.product_name,' ',
            IFNULL(pb.product_brand_name,''),' ',
            IFNULL(pc.category_name,''),' ',
            IFNULL(pg.group_name,''),' ',
            IFNULL(pis.codefor_barcode,'')
        )) LIKE '%{$this->db->escapeLikeString($search)}%'
    ", null, false);
    $builder->groupEnd();

    $builder->having('total_stock >=', 0);

    $builder->orderBy("
        CASE
            WHEN pis.codefor_barcode='{$search}' THEN 1
            WHEN pis.product_name='{$search}' THEN 2
            WHEN pis.product_name LIKE '%".$this->db->escapeLikeString($search)."%' THEN 3
            WHEN pb.product_brand_name LIKE '".$this->db->escapeLikeString($search)."%'
                THEN 4
            WHEN pc.category_name LIKE '".$this->db->escapeLikeString($search)."%'
                THEN 5
            WHEN pg.group_name LIKE '".$this->db->escapeLikeString($search)."%'
                THEN 6
            ELSE 7
        END
    ", false);

    $builder->limit(20);

    return $builder->get()->getResultArray();
}




public function getProductsWithCurrentStock()
{
    $sql = "SELECT
        piq.*,

        pc.category_name,
        pb.product_brand_name,
        pg.group_name,
        ps.strength_name,

        tx.tax_percentage,
        tx.tax_name,

        GREATEST(
            COALESCE(piq.productinitial_quantity,0)
            + COALESCE(ppd.total_purchase_qty,0)
            + COALESCE(rs.total_return,0)
            + COALESCE(adj.total_stock_in,0)
            - COALESCE(sd.total_sale,0)
            - COALESCE(adj.total_stock_out,0)
        ,0) AS total_stock

    FROM product_inital_stock AS piq

    LEFT JOIN (
        SELECT
            product_id,
            SUM((IFNULL(quantity_per_pack,0) * IFNULL(box_quantity,1)) + IFNULL(free_qty,0)) AS total_purchase_qty
        FROM product_purchase_details
        GROUP BY product_id
    ) ppd ON piq.product_id = ppd.product_id

    LEFT JOIN (
        SELECT
            product_id,
            SUM(product_quantity_sold) AS total_sale
        FROM sales_details
        GROUP BY product_id
    ) sd ON piq.product_id = sd.product_id

    LEFT JOIN (
        SELECT
            product_id,
            SUM(return_qty) AS total_return
        FROM return_sales_details
        GROUP BY product_id
    ) rs ON piq.product_id = rs.product_id

    LEFT JOIN (
        SELECT
            sad.product_id,
            SUM(CASE WHEN sa.adjustment_type='stock_in' THEN sad.adjustment_qty ELSE 0 END) AS total_stock_in,
            SUM(CASE WHEN sa.adjustment_type='stock_out' THEN sad.adjustment_qty ELSE 0 END) AS total_stock_out
        FROM stock_adjustment_details sad
        INNER JOIN stock_adjustment sa
            ON sa.adjustment_id = sad.adjustment_id
        GROUP BY sad.product_id
    ) adj ON piq.product_id = adj.product_id

    LEFT JOIN tax tx
        ON piq.tax_id = tx.tax_id

    LEFT JOIN product_category pc
        ON piq.product_category = pc.product_category_id

    LEFT JOIN product_brand pb
        ON piq.product_brand = pb.brand_id

    LEFT JOIN product_group pg
        ON piq.product_group = pg.product_group_id

    LEFT JOIN product_strength ps
        ON piq.product_strength = ps.strength_id

    ORDER BY piq.product_id DESC";

    return $this->db->query($sql)->getResultArray();
}



}

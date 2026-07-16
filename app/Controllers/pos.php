<?php
namespace App\Controllers;

use App\Models\CustomerDueModel;
use App\Models\CustomerModel;
use App\Models\NewProductAddModel;
use App\Models\ProductBrandModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductSaleDetailsModel;
use App\Models\ProductSaleModel;

class Pos extends BaseController
{
    private $product_id_object;
    private $product_sale_object;
    private $product_sale_details_object;
    private $productCategory_object;
    private $ProductBrand_object;
    private $customerModel_object;
    private $customer_due_model_obj;
    private $db;

    public function __construct()
    {
        $this->product_id_object = new NewProductAddModel();
        $this->product_sale_object = new ProductSaleModel();
        $this->product_sale_details_object = new ProductSaleDetailsModel();
        $this->productCategory_object = new ProductCategoryModel();
        $this->ProductBrand_object = new ProductBrandModel();
        $this->customerModel_object = new CustomerModel();
        $this->customer_due_model_obj = new CustomerDueModel();
        $this->db = db_connect();
    }

    public function index()
    {
        $data['product_show_for_sale'] = $this->products(); //products function called
        $data['product_category_show'] = $this->productCategory_object->findAll();
        $data['product_brand_show'] = $this->ProductBrand_object->findAll();
        $data['customer_show'] = $this->customerModel_object->findAll();

        // echo "<pre>";
        // print_r($data['product_show_for_sale']);
        // echo "</pre>";
        // exit();

        $sql_Sale = "SELECT
                    sales.sales_id,
                    sales.sales_invoice,
                    sales.sales_date,
                    sales.other_charge_on_all,
                    SUM(sales_details.product_quantity_sold) AS Sale_Quantity,
                    SUM(sales_details.total_sale_price) AS Total_Sale_Value,
                    SUM(sales_details.unit_price) AS Unite_Price
                FROM sales
                LEFT JOIN sales_details
                    ON sales.sales_invoice = sales_details.sales_details_invoice
                GROUP BY sales.sales_id, sales.sales_invoice, sales.sales_date, sales.other_charge_on_all
                ORDER BY sales_id DESC
                LIMIT 5";

        $data['sales_summery_report_show'] = $this->db->query($sql_Sale)->getResult('array');

        // Fetch held sales
        $data['heldSales'] = $this->db->table('held_sales')
        // ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
        return view('pos/pos_add', $data);
    }

    public function sale()
    {
        $session = session();
        $request = $this->request;
        $db = $this->db;

        $productsList = $request->getPost('cart_data');

        // $discountOnTotalPrice = (float) $request->getPost('discountOnTotalPrice');
        $otherChargeOnTotalPrice = (float) $request->getPost('otherChargeOnTotalPrice');
        $paid = (float) $request->getPost('paid');
        $customer_type = $request->getPost('customer_type');
        $seller_id = $session->get('user_id');

        // =========================
        // AUTO INVOICE GENERATE
        // =========================
        $day_no = date('z') + 1;
        $unique_text = substr(md5(microtime(true) . mt_rand()), -5);
        $invoice_id = strtoupper('INV' . date('y') . str_pad($day_no, 3, '0', STR_PAD_LEFT) . $unique_text);

        // =========================
        // CALCULATION START
        // =========================
        $subtotal = 0;
        $total_vat = 0;
        $total_discount = 0;

        $sales_details_invoice_data = [];

        foreach ($productsList as $row) {

            $qty = (int) $row['quantity'];
            $price = (float) $row['sales_price_for_customer'];

            $line_total = round($qty * $price, 2);

            $vat_percent = (float) ($row['vat'] ?? 0);
            $discount_on_each_product = (float) ($row['discount_on_each_product'] ?? 0);

            $vat_amount = round(($line_total * $vat_percent) / 100, 2);
            ////////////////////
            $discount_type = $row['discount_type']; // "%" or "flat"
            // $lineTotal = $quantity * $sales_price;

            if ($discount_type == '%') {
                $discount_amount = ($line_total * $discount_on_each_product) / 100;
            } else {
                $discount_amount = $discount_on_each_product;
            }
            //////////////////////////
            //  $discount_amount = round(($line_total * $discount_percent) / 100, 2);

            $subtotal += $line_total;
            $total_vat += $vat_amount;
            $total_discount += $discount_amount;

            $sales_details_invoice_data[] = [
                'sales_details_invoice' => $invoice_id,
                'product_id' => $row['product_id'],
                'product_quantity_sold' => $qty,
                'unit_price' => $price,
                'total_sale_price' => $line_total,
                'total_buy_price' => $row['purchase_price'] * $qty,
                // 'productwiseDiscountPercnt' => $discount_percent,
                // 'productwiseDiscountAmount' => $discount_amount,

                // 'productwiseVatPercnt' => $vat_percent,
                // 'productwiseVatAmount' => $vat_amount,
            ];
        }

        // =========================
        // FINAL TOTAL CALCULATION
        // =========================
        // $calculated_total = $subtotal - $total_discount + $total_vat;
        // $due = $calculated_total + $otherChargeOnTotalPrice - $discountOnTotalPrice - $paid;

        $calculated_total = $subtotal - $total_discount + $total_vat;

        $grand_total = $calculated_total + $otherChargeOnTotalPrice;

        $due = $grand_total - $paid;

        // =========================
        // SALES MASTER DATA
        // =========================
        // $sales_data = [
        //     'sales_invoice' => $invoice_id,
        //     'customer_type' => $customer_type,
        //     'sales_date' => date('Y-m-d H:i:s'),
        //     'payment_type' => 'Cash',

        //     'total_amount' => round($calculated_total, 2),

        //     'discountOnTotalPrice' => round($discountOnTotalPrice, 2),
        //     'otherChargeOnTotalPrice' => round($otherChargeOnTotalPrice, 2),

        //     'paid_amount' => $paid,
        //     'due_amount' => round($due, 2),

        //     'seller_id' => $seller_id,
        //     'return_status' => 'ACTIVE',
        // ];

        $sales_data = [

            'sales_invoice' => $invoice_id,
            'customer_type' => $customer_type,
            'sales_date' => date('Y-m-d H:i:s'),
            'payment_type' => 'Cash',

            // Final invoice amount
            'total_amount' => round($grand_total, 2),

            // Product-wise totals
            'product_discount' => round($total_discount, 2),
            'product_vat' => round($total_vat, 2),

            // Invoice-level adjustments
            // 'discount_on_all'      => round($discountOnTotalPrice, 2),
            'other_charge_on_all' => round($otherChargeOnTotalPrice, 2),

            'paid_amount' => $paid,
            'due_amount' => round($due, 2),

            'seller_id' => $seller_id,
            'return_status' => 'ACTIVE',
        ];
        // =========================
        // DATABASE TRANSACTION
        // =========================
        $db->transStart();

        // insert sales
        $this->product_sale_object->insert($sales_data);
        $sales_id = $this->product_sale_object->insertID();

        // insert details
        $this->product_sale_details_object->insertBatch($sales_details_invoice_data);

        // =========================
        // CUSTOMER DUE (optional)
        // =========================
        if ($customer_type !== 'Walk-In-Customer') {
            $this->customer_due_model_obj->insert([
                'due_date' => date('Y-m-d H:i:s'),
                'customer_id' => $customer_type,
                'due_invoice_no' => $invoice_id,
                'due_amount' => $due,
                'due_paid_amount' => 0,
                'current_balance' => 0,
            ]);
        }

        // =========================
        // REMOVE HELD SALES (optional)
        // =========================
        $hold_id = $request->getPost('hold_id');

        if (!empty($hold_id) && is_numeric($hold_id)) {
            $db->table('held_sales')->where('id', $hold_id)->delete();
        }

        $db->transComplete();

        // =========================
        // RESPONSE
        // =========================
        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => 'error',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'invoice' => $invoice_id,
            'sales_id' => $sales_id,
            'total' => round($grand_total, 2),
        ]);
    }

    public function hold_sale()
    {
        $session = session();
        $productsList = $this->request->getVar('cart_data');

        // $discountOnTotalPrice = $this->request->getVar('discountOnTotalPrice');
        $otherChargeOnTotalPrice = $this->request->getVar('otherChargeOnTotalPrice');
        $customer_type = $this->request->getVar('customer_type');
        $seller_id = $session->get('user_id');

        // Auto Hold ID
        $hold_id = strtoupper('HLD' . date('ymdHis') . mt_rand(100, 999));

        $hold_data = [
            'hold_id' => $hold_id,
            'seller_id' => $seller_id,
            'customer_type' => $customer_type,
            'cart_data' => json_encode($productsList),
            // 'discountOnTotalPrice' => $discountOnTotalPrice,
            'otherChargeOnTotalPrice' => $otherChargeOnTotalPrice,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $insert = $this->db->table('held_sales')->insert($hold_data);

        if ($insert) {

            $id = $this->db->insertID(); // actual DB id

            return $this->response->setJSON([
                'status' => 'success',
                'id' => $id,
                'hold_id' => $hold_id,
                'customer_type' => $customer_type,
                'cart_data' => json_decode($hold_data['cart_data'], true),
                //'discountOnTotalPrice' => $discountOnTotalPrice,
                'otherChargeOnTotalPrice' => $otherChargeOnTotalPrice,
            ]);

        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to hold sale!',
            ]);
        }
    }

    public function resume_sale($id)
    {
        $sale = $this->db->table('held_sales')->where('id', $id)->get()->getRowArray();

        if ($sale) {
            $cartData = json_decode($sale['cart_data'], true);

            return $this->response->setJSON([
                'status' => 'success',
                'cart_data' => $cartData ?? [],
                'customer_type' => $sale['customer_type'] ?? 'regular',
                //'discountOnTotalPrice' => $sale['discountOnTotalPrice'] ?? 0,
                'otherChargeOnTotalPrice' => $sale['otherChargeOnTotalPrice'] ?? 0,
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Held sale not found']);
        }
    }

    public function delete_held_sale($hold_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('held_sales');
        $deleted = $builder->delete(['id' => $hold_id]);

        if ($deleted) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete held sale']);
        }
    }

    public function products()
    {
        $category = isset($_POST['product_category']);
        $condition = '';

        if ($category) {
            if ($_POST['product_category'] != 'all_category') {
                $condition = " WHERE pis.product_category = '" . $_POST['product_category'] . "'";
            }
        }

        $sql = "SELECT
            pis.product_id,
            pis.product_name,
            pis.product_image,
            pis.sales_price_for_customer,
            pis.purchase_price,
 
            -- ================= TOTAL STOCK =================
            GREATEST(
                COALESCE(pis.productinitial_quantity,0)
                + COALESCE(ppd.total_purchase_qty,0)
                + COALESCE(rs.total_return,0)
                + COALESCE(adj.total_stock_in,0)
                - COALESCE(sd.total_sale,0)
                - COALESCE(adj.total_stock_out,0)
            ,0) AS total_stock,

            -- ================= TOTAL PURCHASE COST =================
            COALESCE(ppd.total_purchase_cost,0) AS total_purchase_cost,

            -- ================= UNIT PURCHASE PRICE =================
            COALESCE(ppd.unit_purchase_price,pis.purchase_price,0) AS unit_purchase_price,

            -- ================= STOCK VALUE =================
            (
                GREATEST(
                    COALESCE(pis.productinitial_quantity,0)
                    + COALESCE(ppd.total_purchase_qty,0)
                    + COALESCE(rs.total_return,0)
                    + COALESCE(adj.total_stock_in,0)
                    - COALESCE(sd.total_sale,0)
                    - COALESCE(adj.total_stock_out,0)
                ,0)
                *
                COALESCE(ppd.unit_purchase_price,pis.purchase_price,0)
            ) AS stock_value

        FROM product_inital_stock pis

        -- ================= PURCHASE =================
        LEFT JOIN
        (
            SELECT
                product_id,

                SUM(
                    (IFNULL(quantity_per_pack,0) * IFNULL(box_quantity,0))
                    + IFNULL(free_qty,0)
                ) AS total_purchase_qty,

                SUM(purchase_price) AS total_purchase_cost,

                SUM(purchase_price)
                /
                NULLIF(
                    SUM(quantity_per_pack * box_quantity),
                    0
                ) AS unit_purchase_price

            FROM product_purchase_details
            GROUP BY product_id

        ) ppd
        ON ppd.product_id = pis.product_id

        -- ================= SALES =================
        LEFT JOIN
        (
            SELECT
                product_id,
                SUM(product_quantity_sold) AS total_sale
            FROM sales_details
            GROUP BY product_id

        ) sd
        ON sd.product_id = pis.product_id

        -- ================= SALES RETURN =================
        LEFT JOIN
        (
            SELECT
                product_id,
                SUM(return_qty) AS total_return
            FROM return_sales_details
            GROUP BY product_id

        ) rs
        ON rs.product_id = pis.product_id

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
                ) AS total_stock_in,

                SUM(
                    CASE
                        WHEN sa.adjustment_type='stock_out'
                        THEN sad.adjustment_qty
                        ELSE 0
                    END
                ) AS total_stock_out

            FROM stock_adjustment_details sad

            INNER JOIN stock_adjustment sa
                ON sa.adjustment_id = sad.adjustment_id

            /* Uncomment if you use approval status
            WHERE sa.status='Approved'
            */

            GROUP BY sad.product_id

        ) adj
        ON adj.product_id = pis.product_id

        $condition";

        $results = $this->db->query($sql)->getResultArray();

        if ($category) {

            foreach ($results as $row) {
                ?>
<div class="col-3 mb-3 text-center">

    <img data-stock="<?=$row['total_stock'];?>" data-id="<?=$row['product_id'];?>"
        src="<?=base_url('/public/uploads/' . $row['product_image']);?>" class="img-thumbnail cart_item_image shadow-sm"
        style="width:100px;height:80px;object-fit:cover;">

    <p class="mt-2 mb-1 fw-semibold" style="font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
        <?=esc($row['product_name']);?>
    </p>

    <p class="text-primary mb-0" style="font-size:11px;font-weight:600;">
        ৳<?=number_format($row['sales_price_for_customer'], 2);?>
    </p>

    <small class="text-success fw-bold">
        Stock : <?=number_format($row['total_stock'], 2);?>
    </small>

</div>
<?php
}

        } else {

            return $results;

        }
    }

    public function product_call()
    {
        $this->db = db_connect();

        $search = trim($this->request->getGet('term'));

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
            ((pis.productinitial_quantity + IFNULL(ppd.new_purchased,0))
             - IFNULL(sd.total_sale,0))
        ) AS label,

        ((pis.productinitial_quantity + IFNULL(ppd.new_purchased,0))
         - IFNULL(sd.total_sale,0)) AS total_stock
    ");

        // Sales
        $builder->join("
    (
        SELECT product_id,
               SUM(product_quantity_sold) total_sale
        FROM sales_details
        GROUP BY product_id
    ) sd", "pis.product_id=sd.product_id", "left");

        // Purchase
        $builder->join("
    (
        SELECT product_id,
               SUM(quantity_per_pack*box_quantity) new_purchased
        FROM product_purchase_details
        GROUP BY product_id
    ) ppd", "pis.product_id=ppd.product_id", "left");

        // Brand
        $builder->join(
            "product_brand pb",
            "pb.brand_id=pis.product_brand",
            "left"
        );

        // Category
        $builder->join(
            "product_category pc",
            "pc.product_category_id=pis.product_category",
            "left"
        );

        // Group
        $builder->join(
            "product_group pg",
            "pg.product_group_id=pis.product_group",
            "left"
        );

        $search = strtolower(trim($this->request->getGet('term')));

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
            WHEN pis.codefor_barcode='$search' THEN 1
            WHEN pis.product_name='$search' THEN 2
            WHEN pis.product_name LIKE '%" . $this->db->escapeLikeString($search) . "%' THEN 3
            WHEN pb.product_brand_name LIKE '" . $this->db->escapeLikeString($search) . "%' THEN 4
            WHEN pc.category_name LIKE '" . $this->db->escapeLikeString($search) . "%' THEN 5
            WHEN pg.group_name LIKE '" . $this->db->escapeLikeString($search) . "%' THEN 6
            ELSE 7
        END
    ", false);

        $builder->limit(20);

//      echo $builder->getCompiledSelect();
//  die;

        return $this->response->setJSON(
            $builder->get()->getResultArray()
        );
    }

    public function update_hold_sale()
    {
        $id = $this->request->getPost('id');
        $cartData = $this->request->getPost('cart_data');

        if (empty($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid Hold ID',
            ]);
        }

        // If no products remain, delete the held sale
        if (empty($cartData)) {

            $this->db->table('held_sales')
                ->where('id', $id)
                ->delete();

            return $this->response->setJSON([
                'status' => 'deleted',
            ]);
        }

        $this->db->table('held_sales')
            ->where('id', $id)
            ->update([
                'cart_data' => json_encode($cartData),
            ]);

        return $this->response->setJSON([
            'status' => 'success',
        ]);
    }

    public function stockAdjustmentForm()
    {
        $db = \Config\Database::connect();

        $data['product_show_for_sale'] = $this->products(); //products function called

        $data['adjustments'] = $db->table('stock_adjustment sa')
            ->select("
     sa.adjustment_id,
     sa.adjustment_no,
     sa.adjustment_date,
     sa.adjustment_type,
     sa.reason,
     sa.adjusted_by,

     sad.current_stock,
     sad.adjustment_qty,
     sad.new_stock,

     p.product_name,
     u.user_name
 ")
            ->join('stock_adjustment_details sad', 'sad.adjustment_id = sa.adjustment_id')
            ->join('product_inital_stock p', 'p.product_id = sad.product_id')
            ->join('user u', 'u.user_id = sa.adjusted_by', 'left')
            ->orderBy('sa.adjustment_id', 'DESC')
            ->get()
            ->getResultArray();

        return view('product/StockAdjustMentView', $data);
    }

    public function createStockAdjustment()
    {
        $db = \Config\Database::connect();

        $StockAdjustmentModel = new \App\Models\StockAdjustmentModel();
        $StockAdjustmentDetailsModel = new \App\Models\StockAdjustmentDetailsModel();
        // $ProductModel = new \App\Models\ProductInitialStockModel();

        $db->transBegin();

        try {

            // Generate Adjustment No
            $last = $StockAdjustmentModel
                ->orderBy('adjustment_id', 'DESC')
                ->first();

            if ($last) {

                $number = (int) substr($last['adjustment_no'], 3);

                $adjustment_no = 'SA-' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);

            } else {

                $adjustment_no = 'SA-000001';

            }

            $header = [

                'adjustment_no' => $adjustment_no,
                'adjustment_date' => $this->request->getPost('adjustment_date'),
                'adjustment_type' => $this->request->getPost('adjustment_type'),
                'reason' => $this->request->getPost('reason'),
                'reference_no' => $this->request->getPost('reference_no'),
                'remarks' => $this->request->getPost('remarks'),
                'adjusted_by' => session()->get('user_id'),

            ];

            $StockAdjustmentModel->insert($header);
            $adjustment_id = $StockAdjustmentModel->getInsertID();

            //  $product = $ProductModel
            // ->find($this->request->getPost('product_id'));

            $detail = [

                'adjustment_id' => $adjustment_id,
                'product_id' => $this->request->getPost('product_id'),
                'current_stock' => $this->request->getPost('current_stock'),
                'adjustment_qty' => $this->request->getPost('adjustment_qty'),
                'new_stock' => $this->request->getPost('new_stock'),
                //'unit_cost'=>$product['purchase_price']

            ];

            $StockAdjustmentDetailsModel->insert($detail);

            // $ProductModel->update(
            //     $this->request->getPost('product_id'),
            //     [
            //         'total_stock'=>$this->request->getPost('new_stock')
            //     ]
            // );

            $db->transCommit();

            return $this->response->setJSON([

                'status' => 'success',
                'message' => 'Stock Adjustment Saved Successfully.',

            ]);

        } catch (\Exception $e) {

            $db->transRollback();

            return $this->response->setJSON([

                'status' => 'error',
                'message' => $e->getMessage(),

            ]);

        }

    }

    public function view($id)
    {
        $StockAdjustmentModel = new \App\Models\StockAdjustmentModel();

        $data['adjustment'] = $StockAdjustmentModel
            ->where('adjustment_id', $id)
            ->first();

        if (!$data['adjustment']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('stock_adjustment/view', $data);
    }

    public function edit($id)
    {
        $StockAdjustmentModel = new \App\Models\StockAdjustmentModel();

        $data['adjustment'] = $StockAdjustmentModel
            ->where('adjustment_id', $id)
            ->first();

        if (!$data['adjustment']) {
            return redirect()->back()->with('error', 'Record not found');
        }

        return view('stock_adjustment/edit', $data);
    }

}
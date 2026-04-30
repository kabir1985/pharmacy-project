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

        $sql_Sale = "SELECT
                    sales.sales_id,
                    sales.sales_invoice,
                    sales.sales_date,
                    sales.discountOnTotalPrice,
                    sales.vatOnTotalPrice,
                    SUM(sales_details.product_quantity_sold) AS Sale_Quantity,
                    SUM(sales_details.total_sale_price) AS Total_Sale_Value,
                    SUM(sales_details.unit_price) AS Unite_Price
                FROM sales
                LEFT JOIN sales_details
                    ON sales.sales_invoice = sales_details.sales_details_invoice
                GROUP BY sales.sales_id, sales.sales_invoice, sales.sales_date, sales.discountOnTotalPrice, sales.vatOnTotalPrice
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

    // public function sale()
    // {
    //     $session = session();
    //     $request = $this->request;
    //     $productsList = $request->getPost('cart_data'); // array of products

    //     // echo "<pre>";
    //     // print_r($productsList);
    //     // echo "</pre>";

    //     // exit();

    //     // $hold_id = $this->request->getPost('hold_id'); // now this will work
    //     // echo $hold_id;
    //     // exit();

    //     $discountOnTotalPrice = $request->getPost('discountOnTotalPrice');
    //     $vatOnTotalPrice = $request->getPost('vatOnTotalPrice');
    //     $paid = $request->getPost('paid');
    //     $due = $request->getPost('due');
    //     $customer_type = $request->getPost('customer_type');
    //     $seller_id = $session->get('user_id');

    //     // Auto Invoice Generate
    //     $day_no = date('z') + 1;
    //     $unique_text = substr(md5(microtime(true) . mt_Rand()), -5);
    //     $invoice_id = strtoupper('INV' . date('y') . str_pad($day_no, 3, '0', STR_PAD_LEFT) . $unique_text);

    //     $subtotal = 0;

    //     foreach ($productsList as $row) {
    //         $subtotal += $row['quantity'] * $row['sales_price_for_customer'];
    //     }

    //     $total_amount = $subtotal - $discountOnTotalPrice + $vatOnTotalPrice;

    //     $sales_data = [
    //         'sales_invoice' => $invoice_id,
    //         'customer_type' => $customer_type,
    //         'sales_date' => date('Y-m-d H:i:s'),
    //         'payment_type' => 'Cash',

    //         'total_amount' => $total_amount, // ✅ ADD THIS

    //         'discountOnTotalPrice' => $discountOnTotalPrice,
    //         'vatOnTotalPrice' => $vatOnTotalPrice,

    //         'paid_amount' => $paid,
    //         'due_amount' => $total_amount - $paid, // ✅ FIX

    //         'seller_id' => $seller_id,
    //         'return_status' => 'ACTIVE',
    //     ];

    //     // $sales_data = [
    //     //     'sales_invoice' => $invoice_id,
    //     //     'customer_type' => $customer_type,
    //     //     'sales_date' => date('Y-m-d H:i:s'),
    //     //     'payment_type' => 'Cash',
    //     //     'discountOnTotalPrice' => $discountOnTotalPrice,
    //     //     'vatOnTotalPrice' => $vatOnTotalPrice,
    //     //     'paid_amount' => $paid,
    //     //     'due_amount' => $due,
    //     //     'seller_id' => $seller_id,
    //     //     'return_status' => 'ACTIVE',
    //     // ];

    //     $sales_details_invoice_data = [];
    //     foreach ($productsList as $row) {
    //         // $item['sales_details_invoice'] = $invoice_id;
    //         // $item['product_id'] = $row['product_id'];
    //         // $item['product_quantity_sold'] = $row['quantity'];
    //         // $item['unit_price'] = $row['sales_price_for_customer'];
    //         // $item['total_buy_price'] = $row['purchase_price'] * $row['quantity'];
    //         // $item['total_sale_price'] = $row['quantity'] * $row['sales_price_for_customer'];
    //         // $item["productwiseVatPercnt"] = $row['vat'];
    //         // $item["productwiseDiscountPercnt"] = $row['discount_on_each_product'];

    //         $quantity = $row['quantity'];
    //         $unit_price = $row['sales_price_for_customer'];

    //         $line_total = $quantity * $unit_price;

    //         // Convert % → amount (based on line total)
    //         $vat_amount = ($line_total * $row['vat']) / 100;
    //         $discount_amount = ($line_total * $row['discount_on_each_product']) / 100;

    //         $item = [];
    //         $item['sales_details_invoice'] = $invoice_id;
    //         $item['product_id'] = $row['product_id'];

    //         $item['product_quantity_sold'] = $quantity;
    //         $item['unit_price'] = $unit_price;
    //         $item['total_sale_price'] = $line_total;
    //         $item['total_buy_price'] = $row['purchase_price'] * $quantity;

    //         // existing fields (keep unchanged)

    //         $item["productwiseDiscountPercnt"] = $row['discount_on_each_product'];
    //         $item["productwiseDiscountAmount"] = $discount_amount;

    //         $item["productwiseVatPercnt"] = $row['vat'];
    //         $item["productwiseVatAmount"] = $vat_amount;

    //         array_push($sales_details_invoice_data, $item);
    //     }

    //     $this->db->transBegin(); // Start transaction

    //     // Insert main sale
    //     $this->product_sale_object->insert($sales_data);
    //     $lastSalesId = $this->product_sale_object->insertID();

    //     // Insert sale details
    //     $this->product_sale_details_object->insertBatch($sales_details_invoice_data);

    //     // Customer due entry
    //     if ($customer_type !== 'Walk-In-Customer') {
    //         $due_data = [
    //             'due_date' => date('Y-m-d H:i:s'),
    //             'customer_id' => $customer_type,
    //             'due_invoice_no' => $invoice_id,
    //             'due_amount' => $due,
    //             'due_paid_amount' => 0,
    //             'current_balance' => 0,
    //         ];
    //         $this->customer_due_model_obj->insert($due_data);
    //     }

    //     $hold_id = $this->request->getPost('hold_id'); // get from AJAX
    //     if (!empty($hold_id) && is_numeric($hold_id)) {
    //         $this->db->table('held_sales')->where('id', $hold_id)->delete();
    //     }

    //     // Commit or rollback transaction
    //     if ($this->db->transStatus() === false) {
    //         $this->db->transRollback();
    //         $lastSalesId = 0; // fail
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //         ]);
    //     } else {
    //         $this->db->transCommit();

    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             'sales_id' => $lastSalesId,
    //         ]);
    //     }
    // }

    public function sale()
    {
        $session = session();
        $request = $this->request;
        $db = $this->db;

        $productsList = $request->getPost('cart_data');

        $discountOnTotalPrice = (float) $request->getPost('discountOnTotalPrice');
        $vatOnTotalPrice = (float) $request->getPost('vatOnTotalPrice');
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
            $discount_percent = (float) ($row['discount_on_each_product'] ?? 0);

            $vat_amount = round(($line_total * $vat_percent) / 100, 2);
            $discount_amount = round(($line_total * $discount_percent) / 100, 2);

            $subtotal += $line_total;
            $total_vat += $vat_amount;
            $total_discount += $discount_amount;

            ////////////////////////////////////////
//         $qty = $row['quantity'];
// $price = $row['sales_price_for_customer'];

// $line_total = round($qty * $price, 2);

// $discount_amount = round($line_total * ($row['discount_on_each_product'] ?? 0) / 100, 2);
// $vat_amount = round($line_total * ($row['vat'] ?? 0) / 100, 2);

// $net_line = $line_total - $discount_amount + $vat_amount;

//////////////////////////////////////////////////////////

            $sales_details_invoice_data[] = [
                'sales_details_invoice' => $invoice_id,
                'product_id' => $row['product_id'],
                'product_quantity_sold' => $qty,
                'unit_price' => $price,
                'total_sale_price' => $line_total,
                'total_buy_price' => $row['purchase_price'] * $qty,

                'productwiseDiscountPercnt' => $discount_percent,
                'productwiseDiscountAmount' => $discount_amount,

                'productwiseVatPercnt' => $vat_percent,
                'productwiseVatAmount' => $vat_amount,
            ];
        }

        // =========================
        // FINAL TOTAL CALCULATION
        // =========================
        $calculated_total = $subtotal - $total_discount + $total_vat;
        $due = $calculated_total - $paid;

        // =========================
        // SALES MASTER DATA
        // =========================
        $sales_data = [
            'sales_invoice' => $invoice_id,
            'customer_type' => $customer_type,
            'sales_date' => date('Y-m-d H:i:s'),
            'payment_type' => 'Cash',

            'total_amount' => round($calculated_total, 2),

            'discountOnTotalPrice' => round($total_discount, 2),
            'vatOnTotalPrice' => round($total_vat, 2),

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
            'total' => $calculated_total,
        ]);
    }

    public function hold_sale()
    {
        $session = session();
        $productsList = $this->request->getVar('cart_data');

        $discountOnTotalPrice = $this->request->getVar('discountOnTotalPrice');
        $vatOnTotalPrice = $this->request->getVar('vatOnTotalPrice');
        $customer_type = $this->request->getVar('customer_type');
        $seller_id = $session->get('user_id');

        // Auto Hold ID
        $hold_id = strtoupper('HLD' . date('ymdHis') . mt_rand(100, 999));

        $hold_data = [
            'hold_id' => $hold_id,
            'seller_id' => $seller_id,
            'customer_type' => $customer_type,
            'cart_data' => json_encode($productsList),
            'discountOnTotalPrice' => $discountOnTotalPrice,
            'vatOnTotalPrice' => $vatOnTotalPrice,
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
                'discountOnTotalPrice' => $discountOnTotalPrice,
                'vatOnTotalPrice' => $vatOnTotalPrice,
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
                'discountOnTotalPrice' => $sale['discountOnTotalPrice'] ?? 0,
                'vatOnTotalPrice' => $sale['vatOnTotalPrice'] ?? 0,
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
                $condition = 'WHERE pis.product_category = ' . $_POST['product_category'];
            }
        }

        // $sql = "SELECT pis.*, (productinitial_quantity + IFNULL(ppd.new_purchased,0)) - IFNULL(sd.total_sale,0)  AS total_stock
        //         FROM product_inital_stock as pis

        //         LEFT JOIN (SELECT product_id,SUM(product_quantity_sold) as total_sale
        //                         FROM sales_details
        //                         GROUP BY product_id) as sd
        //         ON pis.product_id = sd.product_id

        //         LEFT JOIN (SELECT product_id, SUM(quantity_per_pack * box_quantity) as new_purchased
        //         FROM product_purchase_details
        //         GROUP BY product_id) as ppd
        //         ON pis.product_id = ppd.product_id " . $condition;

        // $results = $this->db->query($sql)->getResult('array');

//         $sql = "SELECT
//  pis.product_id,
//  pis.product_name,
//  pis.product_image,
//  pis.sales_price_for_customer,
//  pis.purchase_price,

//  GREATEST(
//      COALESCE(pis.productinitial_quantity, 0)
//      + COALESCE(ppd.total_purchase, 0)
//      + COALESCE(rs.total_return, 0)
//      - COALESCE(sd.total_sale, 0),
//  0) AS total_stock

// FROM product_inital_stock pis

// LEFT JOIN (
//  SELECT product_id,
//         SUM(quantity_per_pack * box_quantity) AS total_purchase
//  FROM product_purchase_details
//  GROUP BY product_id
// ) ppd ON ppd.product_id = pis.product_id

//     -- total purchase cost
//     IFNULL(SUM((ppd.quantity_per_pack * ppd.box_quantity) * ppd.purchase_price), 0) AS total_purchase_cost,

//   -- ✅ average purchase price
//   CASE
//         WHEN SUM(ppd.quantity_per_pack * ppd.number_of_pack) > 0
//         THEN SUM((ppd.quantity_per_pack * ppd.number_of_pack) * ppd.purchase_price)
//              / SUM(ppd.quantity_per_pack * ppd.number_of_pack)
//         ELSE 0
//     END AS avg_purchase_price

//     FROM products p
// LEFT JOIN product_purchase_details ppd
//     ON p.product_id = ppd.product_id
// GROUP BY p.product_id
// -- ////////////////////////////////

// LEFT JOIN (
//  SELECT product_id,
//         SUM(product_quantity_sold) AS total_sale
//  FROM sales_details
//  GROUP BY product_id
// ) sd ON sd.product_id = pis.product_id

// LEFT JOIN (
//  SELECT product_id,
//         SUM(return_qty) AS total_return
//  FROM return_sales_details
//  GROUP BY product_id
// ) rs ON rs.product_id = pis.product_id; ";

// $sql = "SELECT
//     pis.product_id,
//     pis.product_name,
//     pis.product_image,
//     pis.sales_price_for_customer,
//     pis.purchase_price,

//     GREATEST(
//         COALESCE(pis.productinitial_quantity, 0)
//         + COALESCE(ppd.total_purchase, 0)
//         + COALESCE(rs.total_return, 0)
//         - COALESCE(sd.total_sale, 0)
//     , 0) AS total_stock,

//     COALESCE(ppd.total_purchase_cost, 0) AS total_purchase_cost,
//     COALESCE(ppd.avg_purchase_price, 0) AS avg_purchase_price

// FROM product_inital_stock pis

// LEFT JOIN (
//     SELECT
//         product_id,
//         SUM(quantity_per_pack * box_quantity) AS total_purchase,

//         SUM((quantity_per_pack * box_quantity) * purchase_price) AS total_purchase_cost,

//         CASE
//             WHEN SUM(quantity_per_pack * box_quantity) > 0
//             THEN SUM((quantity_per_pack * box_quantity) * purchase_price)
//                  / SUM(quantity_per_pack * box_quantity)
//             ELSE 0
//         END AS avg_purchase_price

//     FROM product_purchase_details
//     GROUP BY product_id
// ) ppd ON ppd.product_id = pis.product_id

// LEFT JOIN (
//     SELECT product_id,
//            SUM(product_quantity_sold) AS total_sale
//     FROM sales_details
//     GROUP BY product_id
// ) sd ON sd.product_id = pis.product_id

// LEFT JOIN (
//     SELECT product_id,
//            SUM(return_qty) AS total_return
//     FROM return_sales_details
//     GROUP BY product_id
// ) rs ON rs.product_id = pis.product_id
// ";

$sql = "SELECT
    pis.product_id,
    pis.product_name,
    pis.product_image,
    pis.sales_price_for_customer,
    pis.purchase_price,

    -- ================= TOTAL STOCK =================
    GREATEST(
        COALESCE(pis.productinitial_quantity, 0)
        + COALESCE(ppd.total_purchase_qty, 0)
        + COALESCE(rs.total_return, 0)
        - COALESCE(sd.total_sale, 0)
    , 0) AS total_stock,

    -- ================= TOTAL PURCHASE COST =================
    COALESCE(ppd.total_purchase_cost, 0) AS total_purchase_cost,

    -- ================= PER UNIT PURCHASE PRICE =================
    COALESCE(ppd.unit_purchase_price, pis.purchase_price, 0) AS unit_purchase_price,

    -- ================= STOCK VALUE =================
    GREATEST(
        COALESCE(pis.productinitial_quantity, 0)
        + COALESCE(ppd.total_purchase_qty, 0)
        + COALESCE(rs.total_return, 0)
        - COALESCE(sd.total_sale, 0)
    , 0) * COALESCE(ppd.unit_purchase_price, pis.purchase_price, 0) AS stock_value

FROM product_inital_stock pis

-- ================= PURCHASE =================
LEFT JOIN (
    SELECT
        product_id,

        -- total quantity purchased
        SUM(quantity_per_pack * box_quantity) AS total_purchase_qty,

        -- total cost (your stored line cost)
        SUM(purchase_price) AS total_purchase_cost,

        -- ================= PER UNIT PRICE =================
        SUM(purchase_price)
        / NULLIF(SUM(quantity_per_pack * box_quantity), 0) AS unit_purchase_price

    FROM product_purchase_details
    GROUP BY product_id
) ppd ON ppd.product_id = pis.product_id

-- ================= SALES =================
LEFT JOIN (
    SELECT
        product_id,
        SUM(product_quantity_sold) AS total_sale
    FROM sales_details
    GROUP BY product_id
) sd ON sd.product_id = pis.product_id

-- ================= RETURN =================
LEFT JOIN (
    SELECT
        product_id,
        SUM(return_qty) AS total_return
    FROM return_sales_details
    GROUP BY product_id
) rs ON rs.product_id = pis.product_id
";


        $results = $this->db->query($sql)->getResultArray();

        if ($category) {
            foreach ($results as $key => $row) {
                ?>
<div class="col-3 mb-3 text-center">
    <!-- Product Image -->
    <img data-stock="<?php echo $row["total_stock"] ?>" data-id="<?php echo $row["product_id"] ?>"
        src="<?php echo base_url('/public/uploads/' . $row["product_image"]) ?>"
        class="img-thumbnail cart_item_image shadow-sm" alt="<?php echo htmlspecialchars($row["product_name"]) ?>"
        style="width: 100px; height: 80px; object-fit: cover;">

    <!-- Product Name -->
    <p class="mt-2 mb-1 fw-semibold text-dark"
        style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        <?php echo htmlspecialchars($row["product_name"]) ?>
    </p>

    <!-- Product Price -->
    <p class="text-primary mb-0" style="font-size: 0.7rem; font-weight: 600;">
        ৳<?php echo number_format($row["sales_price_for_customer"], 2) ?>
    </p>
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
        $search_product = $_GET['term'];

        $sql = "SELECT pis.product_id as id,pis.product_name as name,pis.product_name as label,
               ((productinitial_quantity + IFNULL(ppd.new_purchased,0)) - IFNULL(sd.total_sale,0))  AS total_stock
                FROM product_inital_stock as pis

                LEFT JOIN (SELECT product_id,SUM(product_quantity_sold) as total_sale
                                FROM sales_details
                                GROUP BY product_id) as sd ON pis.product_id = sd.product_id

                LEFT JOIN (SELECT product_id,SUM(quantity_per_pack * box_quantity) as new_purchased
                                FROM product_purchase_details
                                GROUP BY product_id) as ppd ON pis.product_id = ppd.product_id
                WHERE ((productinitial_quantity + IFNULL(ppd.new_purchased,0)) - IFNULL(sd.total_sale,0))>0 AND  product_name like '%$search_product%' ";

        $results = $this->db->query($sql)->getResult('array');
        echo(json_encode($results));
    }
}
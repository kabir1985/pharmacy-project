<?php
namespace App\Controllers;

use App\Models\CustomerDueModel;
use App\Models\CustomerModel;
use App\Models\NewProductAddModel;
use App\Models\ProductBrandModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductSaleDetailsModel;
use App\Models\ProductSaleModel;
use App\Models\CustomerGroupModel;

class PosController extends BaseController
{
    protected NewProductAddModel $products_object;
    protected ProductSaleModel $product_sale_object;
    protected ProductSaleDetailsModel $product_sale_details_object;
    protected ProductCategoryModel $productCategory_object;
    protected ProductBrandModel $ProductBrand_object;
    protected CustomerModel $customerModel_object;
    protected CustomerDueModel $customer_due_model_obj;
     protected CustomerGroupModel $customerGroupObject;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->products_object = new NewProductAddModel();
        $this->product_sale_object = new ProductSaleModel();
        $this->product_sale_details_object = new ProductSaleDetailsModel();
        $this->productCategory_object = new ProductCategoryModel();
        $this->ProductBrand_object = new ProductBrandModel();
        $this->customerModel_object = new CustomerModel();
        $this->customer_due_model_obj = new CustomerDueModel();
        $this->customerGroupObject = new CustomerGroupModel();
        // $this->db = db_connect();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $category = $this->request->getPost('product_category');

        $data['product_show_for_sale'] = $this->products_object->getProducts($category);

        $data['product_category_show'] = $this->productCategory_object->findAll();
        $data['product_brand_show'] = $this->ProductBrand_object->findAll();
        $data['customer_show'] = $this->customerModel_object->findAll();
        $data['customer_group_show'] = $this->customerGroupObject->findAll();

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

        $data['sales_summery_report_show'] = $this->db->query($sql_Sale)->getResultArray();

        $data['heldSales'] = $this->db->table('held_sales')
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

    if (empty($productsList) || !is_array($productsList)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Cart is empty.'
        ]);
    }

    $otherChargeOnTotalPrice = (float) $request->getPost('otherChargeOnTotalPrice');
    $paid                    = (float) $request->getPost('paid');
    $customer_id             = $request->getPost('customer_id');
    $seller_id               = $session->get('user_id');

    // Walk-In Customer
$customer_id = $request->getPost('customer_id');

if (empty($customer_id)) {
    $customer_id = null;
}

    // =========================
    // AUTO INVOICE GENERATE
    // =========================
    $day_no      = date('z') + 1;
    $unique_text = strtoupper(substr(md5(microtime(true) . mt_rand()), -5));
    $invoice_id  = 'INV' . date('y') . str_pad($day_no, 3, '0', STR_PAD_LEFT) . $unique_text;

    // =========================
    // CALCULATION
    // =========================
    $subtotal       = 0;
    $total_vat      = 0;
    $total_discount = 0;

    $sales_details_invoice_data = [];

    foreach ($productsList as $row) {

        $qty   = (int) $row['quantity'];
        $price = (float) $row['sales_price_for_customer'];

        $line_total = round($qty * $price, 2);

        $vat_percent = (float) ($row['vat'] ?? 0);
        $vat_amount  = round(($line_total * $vat_percent) / 100, 2);

        $discount_value = (float) ($row['discount_on_each_product'] ?? 0);
        $discount_type  = $row['discount_type'] ?? '%';

        if ($discount_type === '%') {
            $discount_amount = round(($line_total * $discount_value) / 100, 2);
        } else {
            $discount_amount = round($discount_value, 2);
        }

        $subtotal       += $line_total;
        $total_vat      += $vat_amount;
        $total_discount += $discount_amount;

        $sales_details_invoice_data[] = [
            'sales_details_invoice' => $invoice_id,
            'product_id'            => $row['product_id'],
            'product_quantity_sold' => $qty,
            'unit_price'            => $price,
            'total_sale_price'      => $line_total,
            'total_buy_price'       => $row['purchase_price'] * $qty,
        ];
    }

    // =========================
    // FINAL TOTAL
    // =========================
    $calculated_total = $subtotal - $total_discount + $total_vat;

    $grand_total = $calculated_total + $otherChargeOnTotalPrice;

    $due = max(0, round($grand_total - $paid, 2));

    // =========================
    // SALES MASTER
    // =========================
    $sales_data = [
        'sales_invoice'        => $invoice_id,
        'customer_id'          => $customer_id, // NULL for Walk-In Customer
        'sales_date'           => date('Y-m-d H:i:s'),
        'payment_type'         => 'Cash',

        'total_amount'         => round($grand_total, 2),

        'product_discount'     => round($total_discount, 2),
        'product_vat'          => round($total_vat, 2),

        'other_charge_on_all'  => round($otherChargeOnTotalPrice, 2),

        'paid_amount'          => round($paid, 2),
        'due_amount'           => $due,

        'seller_id'            => $seller_id,
        'return_status'        => 'NO_RETURN',
    ];

    // =========================
    // DATABASE TRANSACTION
    // =========================
    $db->transBegin();

    try {

        // Sales Master
        $this->product_sale_object->insert($sales_data);
        $sales_id = $this->product_sale_object->insertID();

        // Sales Details
        $this->product_sale_details_object->insertBatch($sales_details_invoice_data);

        //customer due

  if ($customer_id !== null && $due > 0) {
    $this->customer_due_model_obj->insert([
        'customer_id' => $customer_id,
        'sales_id'    => $sales_id,
        'due_amount'  => $due,
        'paid_amount' => 0,
    ]);
}

        // Remove Held Sale
        $hold_id = $request->getPost('hold_id');

        if (!empty($hold_id) && is_numeric($hold_id)) {
            $db->table('held_sales')
                ->where('id', $hold_id)
                ->delete();
        }

        if ($db->transStatus() === false) {
            throw new \Exception('Transaction failed.');
        }

        $db->transCommit();

        return $this->response->setJSON([
            'status'   => 'success',
            'invoice'  => $invoice_id,
            'sales_id' => $sales_id,
            'total'    => round($grand_total, 2),
            'message'  => 'Sale completed successfully.'
        ]);

    } catch (\Throwable $e) {

        $db->transRollback();

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => $e->getMessage()
        ]);
    }
}


    public function productSearch()
    {
        $search = $this->request->getGet('term');

        return $this->response->setJSON(
            $this->products_object->searchProducts($search)
        );
    }

    public function hold_sale()
    {
        $session = session();
        $productsList = $this->request->getVar('cart_data');

        // $discountOnTotalPrice = $this->request->getVar('discountOnTotalPrice');
        $otherChargeOnTotalPrice = $this->request->getVar('otherChargeOnTotalPrice');
        $customer_id = $this->request->getVar('customer_id');
        $seller_id = $session->get('user_id');

        // Auto Hold ID
        $hold_id = strtoupper('HLD' . date('ymdHis') . mt_rand(100, 999));

        $hold_data = [
            'hold_id' => $hold_id,
            'seller_id' => $seller_id,
            'customer_id' => $customer_id,
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
                'customer_id' => $customer_id,
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

public function resume_sale($id = null)
{
    if (empty($id) || !is_numeric($id)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Invalid Hold Sale ID.'
        ]);
    }

    $sale = $this->db->table('held_sales')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$sale) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Held sale not found.'
        ]);
    }

    return $this->response->setJSON([
        'status'                  => 'success',
        'cart_data'               => json_decode($sale['cart_data'], true) ?? [],
        'customer_id'             => !empty($sale['customer_id']) ? (int) $sale['customer_id'] : '',
        'otherChargeOnTotalPrice' => (float) ($sale['otherChargeOnTotalPrice'] ?? 0),
    ]);
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

///////////////Product Category Selection////////////////////
    public function filterProducts()
    {
        $category = $this->request->getPost('product_category');

        $data['products'] = $this->products_object->getProducts($category);

        return view('pos/product_cards', $data);
    }
/////////////////////////////////////////////////////////////////////

}

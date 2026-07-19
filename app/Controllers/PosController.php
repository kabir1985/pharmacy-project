<?php
namespace App\Controllers;

use App\Models\CustomerDueModel;
use App\Models\CustomerModel;
use App\Models\NewProductAddModel;
use App\Models\ProductBrandModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductSaleDetailsModel;
use App\Models\ProductSaleModel;

class PosController extends BaseController
{
    protected NewProductAddModel $products_object;
    protected ProductSaleModel $product_sale_object;
    protected ProductSaleDetailsModel $product_sale_details_object;
    protected ProductCategoryModel $productCategory_object;
    protected ProductBrandModel $ProductBrand_object;
    protected CustomerModel $customerModel_object;
    protected CustomerDueModel $customer_due_model_obj;
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

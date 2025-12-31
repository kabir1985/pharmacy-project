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
        $data['product_show_for_sale'] = $this->products();
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

    public function sale()
    {
        $session = session();
        /*########################### Sales & Sales_details Table Entry ####################################### */
        $productsList = $this->request->getPost('cart_data'); // array of products

        $discountOnTotalPrice = $_POST['discountOnTotalPrice'];
        $vatOnTotalPrice = $_POST['vatOnTotalPrice'];
        $paid = $_POST['paid'];
        $due = $_POST['due'];

        $customer_type = $_POST['customer_type'];
     //   $seller_id = $session->get('user_id');

     $seller_id = 0;

        // echo "<pre>";
        // print_r($productsList);
        // echo "</pre>";
        // echo $seller_id;
        // exit();

        ///// Auto Invoice Generate
        $day_no = date('z') + 1;
        $unique_text = substr(md5(microtime(true) . mt_Rand()), -5);
        $invoice_id = strtoupper('INV' . date('y') . str_pad($day_no, 3, '0', STR_PAD_LEFT) . '' . $unique_text);

        $lastSalesId = 0;

        $sales_data = [
            'sales_invoice' => $invoice_id,
            'customer_type' => $customer_type,
            'sales_date' => date('Y-m-d H:i:s'),
            'payment_type' => 'Cash',
            'discountOnTotalPrice' => $discountOnTotalPrice,
            'vatOnTotalPrice' => $vatOnTotalPrice,
            'paid_amount' => $paid,
            'due_amount' => $due,
            'seller_id' => $seller_id,
        ];

        $sales_details_invoice_data = [];

        foreach ($productsList as $row) {
            $item['sales_details_invoice'] = $invoice_id;
            $item['product_id'] = $row['product_id'];
            $item['product_quantity_sold'] = $row['quantity'];
            $item['unit_price'] = $row['selling_unit_price'];
            $item['total_buy_price'] = $row['buying_unit_price'] * $row['quantity'];
            $item['total_sale_price'] = $row['quantity'] * $row['selling_unit_price'];
            $item["productwiseVatPercnt"] = $row['vat'];
            $item["productwiseDiscountPercnt"] = $row['discount_on_each_product'];
            array_push($sales_details_invoice_data, $item);
        }
        $this->db->transBegin(); //transaction start here
        $this->product_sale_object->insert($sales_data);
        $lastSalesId = $this->product_sale_object->insertID();

       // echo "Sales ID is: ".$lastSalesId;
       // exit();

        $this->product_sale_details_object->insertBatch($sales_details_invoice_data);

        /////////////////////Customer Due Table Entry///////////

        if ($customer_type !== 'Walk-In-Customer') {
            $data = [
                'due_date' => date('Y-m-d H:i:s'),
                'customer_id' => $customer_type,
                'due_invoice_no' => $invoice_id,
                'due_amount' => $due,
                'due_paid_amount' => 0,
                'current_balance' => 0,
            ];
            $this->customer_due_model_obj->insert($data);
        }
        //////////////////Customer Due Table End/////////////

        $isSuccess = false;

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
        } else {
            $isSuccess = true;
            $this->db->transCommit(); //transaction commit here but if not commit then roll back txn
        }
        $this->db->transComplete();

        if ($isSuccess) {
            $sales = ["sales_id" => $lastSalesId];
            return json_encode($sales);

        } else {
            $sales = ["sales_id" => 0];
            return json_encode($sales);
        }
        ;

        //txn complete successfully

        /*########################### Sales & Sales_details Table Entry End ####################################### */
    }


    public function hold_sale()
    {

        $session = session();
        $productsList = $this->request->getVar('cart_data');


        // echo "<pre>";
// print_r($productsList);
// echo "</pre>";
// exit();

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
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('held_sales')->insert($hold_data);

        //return $this->response->setJSON(['status' => 'success', 'hold_id' => $hold_id, 'customer_type' => $customer_type]);


        if ($hold_data) {
            return $this->response->setJSON([
                'status' => 'success',
                'cart_data' => json_decode($hold_data['cart_data'], true), // decode to array
                'discountOnTotalPrice' => $hold_data['discountOnTotalPrice'],
                'vatOnTotalPrice' => $hold_data['vatOnTotalPrice'],
                'customer_type' => $hold_data['customer_type']
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Hold Sale not found!'
            ]);
        }



    }



    // Resume a held sale
    public function resume_sale($id)
    {
        $sale = $this->db->table('held_sales')->where('id', $id)->get()->getRowArray();

        if ($sale) {
            //$cartData = json_decode($sale['cart_data'], true);
            $cartData = json_decode($sale['seller_id'], true);

            return $this->response->setJSON([
                'status' => 'success',
                'cart_data' => $cartData
                // 'customer_type' => $sale['customer_type'],
                // 'discountOnTotalPrice' => $sale['discountOnTotalPrice'],
                // 'vatOnTotalPrice' => $sale['vatOnTotalPrice']
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Held sale not found']);
        }
    }





    public function products()
    {

        $category = isset($_POST['product_category']);
        $condition = '';
        if ($category) {

            if ($_POST['product_category'] != 'all_category') {
                $condition = 'WHERE piq.product_category = ' . $_POST['product_category'];
            }
        }

        $sql = "SELECT piq.*, (productinitial_quantity + IFNULL(ppd.new_purchased,0)) - IFNULL(sd.total_sale,0)  AS total_stock
                FROM product_inital_stock as piq

                LEFT JOIN (SELECT product_id,SUM(product_quantity_sold) as total_sale
                                FROM sales_details
                                GROUP BY product_id) as sd
                ON piq.product_id = sd.product_id

                LEFT JOIN (SELECT product_id,SUM(quantity) as new_purchased
                FROM product_purchase_details
                GROUP BY product_id) as ppd
                ON piq.product_id = ppd.product_id " . $condition;

        $results = $this->db->query($sql)->getResult('array');

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
                        ৳<?php echo number_format($row["selling_unit_price"], 2) ?>
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

        $sql = "SELECT piq.product_id as id,piq.product_name as name,piq.product_name as label,
               ((productinitial_quantity + IFNULL(ppd.new_purchased,0)) - IFNULL(sd.total_sale,0))  AS total_stock
                FROM product_inital_stock as piq

                LEFT JOIN (SELECT product_id,SUM(product_quantity_sold) as total_sale
                                FROM sales_details
                                GROUP BY product_id) as sd ON piq.product_id = sd.product_id

                LEFT JOIN (SELECT product_id,SUM(quantity) as new_purchased
                                FROM product_purchase_details
                                GROUP BY product_id) as ppd ON piq.product_id = ppd.product_id
                WHERE ((productinitial_quantity + IFNULL(ppd.new_purchased,0)) - IFNULL(sd.total_sale,0))>0 AND  product_name like '%$search_product%' ";

        $results = $this->db->query($sql)->getResult('array');
        echo (json_encode($results));
    }
}
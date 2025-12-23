<?php
namespace App\Controllers;
use App\Models\ProductSaleModel;
use App\Models\ProductSaleDetailsModel;
use App\Models\CustomerDueModel;

use App\Models\ReturnSaleModel;
use App\Models\ReturnSaleDetailsModel;
use App\Models\ReturnCustomerDueModel;
use CodeIgniter\HTTP\IncomingRequest;

class ReturnController extends BaseController
{

    private $db;

    public function __construct()
    {
        //$this->product_initial_stock_object = new NewProductAddModel();
        $this->db = db_connect();
    }

// Get products for an invoice
public function getProducts()
{
    $invoice = $this->request->getGet('invoice');

    $products = $this->db->table('sales_details')
        ->where('sales_details_invoice', $invoice)
        ->get()
        ->getResultArray();

    return $this->response->setJSON($products);
}

// // Process return
// public function process()
// {
//     $invoice = $this->request->getPost('return_invoice');
//     $return_qty = $this->request->getPost('return_qty'); // array product_id => qty
//     $reason = $this->request->getPost('reason');

//     foreach($return_qty as $product_id => $qty) {
//         if($qty > 0){
//             $product = $this->db->table('sales_details')
//                             ->where('sales_details_invoice', $invoice)
//                             ->where('product_id', $product_id)
//                             ->get()->getRowArray();

//             $return_amount = $qty * $product['unit_price'];

//             // Insert into sales_return table
//             $this->db->table('sales_return')->insert([
//                 'sales_invoice' => $invoice,
//                 'product_id' => $product_id,
//                 'return_quantity' => $qty,
//                 'return_amount' => $return_amount,
//                 'reason' => $reason,
//                 'return_date' => date('Y-m-d H:i:s'),
//                 'seller_id' => $product['seller_id']
//             ]);

//             // Update sales_details
//             $this->db->table('sales_details')
//                      ->where('sales_details_invoice', $invoice)
//                      ->where('product_id', $product_id)
//                      ->set('product_quantity_sold', 'product_quantity_sold-'.$qty, false)
//                      ->update();

//             // Update sales table
//             $this->db->table('sales')
//                      ->where('sales_invoice', $invoice)
//                      ->set('due_amount', 'due_amount-'.$return_amount, false)
//                      ->set('paid_amount', 'paid_amount-'.$return_amount, false)
//                      ->update();

//             // Update customer_due
//             $this->db->table('customer_due')
//                      ->where('due_invoice_no', $invoice)
//                      ->set('due_amount', 'due_amount-'.$return_amount, false)
//                      ->update();
//         }
//     }

//     return $this->response->setJSON([
//         'status' => 'success',
//         'message' => 'Sales Return Processed Successfully'
//     ]);
// }


// Process Return
public function process()
{
    $invoice = $this->request->getPost('return_invoice');
    $return_qty = $this->request->getPost('return_qty'); // array product_id => qty
    $reason = $this->request->getPost('reason');

    foreach($return_qty as $product_id => $qty){
        if($qty > 0){
            $product = $this->db->table('sales_details')
                            ->where('sales_details_invoice', $invoice)
                            ->where('product_id', $product_id)
                            ->get()->getRowArray();

            $return_amount = $qty * $product['unit_price'];

            // Insert into sales_return
            $this->db->table('sales_return')->insert([
                'sales_invoice' => $invoice,
                'product_id' => $product_id,
                'return_quantity' => $qty,
                'return_amount' => $return_amount,
                'reason' => $reason,
                'return_date' => date('Y-m-d H:i:s'),
                'seller_id' => $product['seller_id']
            ]);

            // Update sales_details quantity
            $this->db->table('sales_details')
                     ->where('sales_details_invoice', $invoice)
                     ->where('product_id', $product_id)
                     ->set('product_quantity_sold', 'product_quantity_sold-'.$qty, false)
                     ->update();
        }
    }

    // Update total sale, due, paid in sales table
    $total_return = array_sum(array_map(function($p,$q) use ($product) { return $p * $q; }, array_values($return_qty), array_keys($return_qty)));

    $this->db->table('sales')
             ->where('sales_invoice', $invoice)
             ->set('due_amount', 'due_amount-'.$total_return, false)
             ->update();

    return $this->response->setJSON(['status'=>'success','message'=>'Sales Return Processed Successfully']);
}




}

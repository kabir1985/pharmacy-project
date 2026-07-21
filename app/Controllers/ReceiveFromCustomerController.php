<?php

namespace App\Controllers;

use App\Models\CustomerDueModel;
use CodeIgniter\HTTP\IncomingRequest;

class ReceiveFromCustomerController extends BaseController
{

    private $customerduepayment_obj;
    private $db;

    public function __construct()
     {
         $this->customerduepayment_obj = new CustomerDueModel();
         $this->db = db_connect();

     } 
 
    public function index()
    {
        $sql = "SELECT 
            customer_due.customer_id, 
            customer.cus_first_name,
            customer.cus_phone,
            customer.cus_company, 
            MAX(customer_due.due_invoice_no) AS due_invoice_no,
            SUM(customer_due.due_amount) AS Total_Customer_due,
            SUM(customer_due.due_paid_amount) AS Customer_total_paid,
            MAX(customer_due.due_id) AS due_id
        FROM customer_due
        LEFT JOIN customer ON customer_due.customer_id = customer.customer_id 
        GROUP BY 
            customer_due.customer_id,
            customer.cus_first_name,
            customer.cus_phone,
            customer.cus_company
        ORDER BY customer_due.customer_id DESC";

       $data['customer_due_show'] = $this->db->query($sql)->getResult('array');

	   return view('payment/fromcustomerAdd', $data);
     }

    // due_invoice_no

    public function create()
    {
        $data = [
            //due_date, customer_id, due_invoice_no, due_amount, due_paid_amount, current_balance
            'due_date'        => date("Y-m-d"),
            'customer_id'    => $this->request->getVar('customer_id'),
            'due_invoice_no'     => $this->request->getVar('due_invoice_no'),
            'due_amount'        => 0,
            'due_paid_amount'        => $this->request->getVar('paid_now'),
            'current_balance' => 0
        ];
 
    $d = $this->customerduepayment_obj->insert($data);
        if($d>0)
        { 
            echo "1";
        }
        else
        {
            echo "0";
        }
    }


    // public function update($id = 0)
    // {
    //     $id = $this->request->getVar('customer_id');
    //     //echo $id;
    //     $data = [
    //         'cus_first_name'    => $this->request->getVar('cus_first_name'),
    //         'cus_last_name'     => $this->request->getVar('cus_last_name'),
    //         'cus_email'        => $this->request->getVar('cus_email'),
    //         'cus_phone'        => $this->request->getVar('cus_phone'),
    //         'cus_address'      => $this->request->getVar('cus_address'),
    //         'cus_tin'          => $this->request->getVar('cus_tin'),
    //         'cus_company'     => $this->request->getVar('cus_company')
    //     ];

    //     $d =  $this->customerModelObject->update($id, $data);
    //             //$d = $this->customerModelObject->insert($data);
    //     if($d>0)
    //     { 
    //         echo "1";
    //     }
    //     else
    //     {
    //         echo "0";
    //     }
    // }


    // public function delete($id = 0)
    // {

    //     $id = $this->request->getVar('delete_id');

    //     $this->customerModelObject->where('customer_id', $id)->delete();

    //     //return into supplier page
    //     return $this->response->redirect(site_url('/Customer'));
    // } 
}

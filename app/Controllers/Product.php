<?php

namespace App\Controllers;

use App\Models\NewProductAddModel;
use App\Models\ProductBrandModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductGroupModel;
use App\Models\ProductUnitModel;
use App\Models\TaxModel;

class Product extends BaseController
{
    private $productCategory_object;
    private $NewProductAddModel_Object;
    private $ProductBrandModel;
    private $productgroup_object;
    private $productunit_object;
    private $tax_object;
    //private $db;
    protected $db;

    public function __construct()
    {
        $this->NewProductAddModel_Object = new NewProductAddModel();
        $this->productCategory_object = new ProductCategoryModel();
        $this->ProductBrandModel = new ProductBrandModel();
        $this->productgroup_object = new ProductGroupModel();
        $this->productunit_object = new ProductUnitModel();
        $this->tax_object = new TaxModel();
        //$this->db = \Config\Database::connect();
        $this->db = db_connect();
    }

    public function index()
    {
        $data['category_show'] = $this->productCategory_object->findAll();
        $data['brand_show'] = $this->ProductBrandModel->findAll();
        $data['group_show'] = $this->productgroup_object->findAll();
        $data['unit_show'] = $this->productunit_object->findAll();
        $data['tax_show'] = $this->tax_object->findAll();

        $sql = "SELECT * FROM product_inital_stock AS pr
      LEFT JOIN product_category AS pc ON pr.product_category = pc.product_category_id
      LEFT JOIN product_group AS pg ON pr.product_group = pg.product_group_id
      LEFT JOIN product_brand AS pb ON pr.product_brand = pb.brand_id
      LEFT JOIN product_unit AS pu ON pr.product_unit = pu.product_unit_id
      LEFT JOIN tax AS tx ON pr.tax_id = tx.tax_id
      ";

        $data['product_show'] = $this->db->query($sql)->getResult('array');

//       echo '<pre>';
// print_r($data['product_show']);
// exit;

        return view('product/NewProductAdd', $data);
    }

    //--------------------------------------------------------------------

    public function create()
    {

        /////////////////////For Image Upload////////////////////////////////
        helper(['form', 'url']);

        // $db      = \Config\Database::connect();
        $this->db = db_connect();
        $builder = $this->db->table('product_inital_stock');

        $validated = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[file,4096]',
            ],
        ]);

        $msg = 'Please select a valid file';
        //exit(WRITEPATH);
        if ($validated) {
            $avatar = $this->request->getFile('file');
            // $avatar->move(WRITEPATH . 'uploads');

            //$avatar->move(WRITEPATH . 'assets/images');
            $avatar->move(ROOTPATH . 'public/uploads/');
        }

        $tax_id = $this->request->getPost('tax_id');
        $tax_percentage = $this->request->getPost('tax_percentage');
        $base_price = (float) $this->request->getVar('base_price');
        $purchase_price = (float) $this->request->getVar('purchase_price');
        $tax_type_db = ($this->request->getVar('tax_type') == 'with_tax') ? 'with_tax' : 'without_tax';
        $profit_margin = (int) $this->request->getVar('profit_margin');
        $sales_price = $this->request->getVar('sales_price');

        if ($tax_type_db == 'with_tax') { // Inclusive tax

            //  $base_price = $purchase_price / (1 + $tax_percentage/100);
            //  $tax_amount = $purchase_price - $base_price;

            $tax_amount = $base_price * $tax_percentage / (100 + $tax_percentage);

            $cost_without_vat = $base_price - $tax_amount;

            $sales_price_for_customer = $sales_price;

        } else { // Exclusive tax

            $tax_amount = ($base_price * $tax_percentage) / 100;
           // VAT added separately
            $purchase_price = $base_price + $tax_amount;

            $cost_without_vat = $base_price;

        }

        $base_price = round($base_price, 2);
        $tax_amount = round($tax_amount, 2);
        $purchase_price = round($purchase_price, 2);
/////////////////////////////////////////

        $data = [
            'product_name' => $this->request->getVar('product_name'),
            'product_category' => $this->request->getVar('product_category'),
            'product_brand' => $this->request->getVar('product_brand'),
            'product_group' => (int) $this->request->getVar('product_group'),
            'product_unit' => $this->request->getVar('product_unit'),
            'codefor_barcode' => $this->request->getVar('codefor_barcode'),
            'productinitial_quantity' => (int) $this->request->getVar('productinitial_quantity'),

            'base_price' => $base_price,
            'cost_without_vat' => $cost_without_vat,
            'tax_type' => $tax_type_db,
            'tax_id' => $tax_id,
            'tax_amount' => $tax_amount,
            
            'purchase_price' => $purchase_price,
            'profit_margin_%' => $profit_margin,
            'sales_price_for_customer' => $sales_price,
            'alert_quantity' => (int) $this->request->getVar('alert_quantity'),
            'product_image' => $avatar->getClientName(),
        ];

        $id = $this->NewProductAddModel_Object->insert($data);

        if ($id > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function update($id = 0)
    {
        $id = $this->request->getVar('product_id');

// echo "1";
// exit();

        $data = [
            'product_name' => $this->request->getVar('product_name'),
            'product_category' => $this->request->getVar('product_category12'),
            'product_brand' => $this->request->getVar('product_brand12'),
            'product_group' => $this->request->getVar('product_group12'),
            'product_unit' => $this->request->getVar('product_unit12'),
            'codefor_barcode' => $this->request->getVar('codefor_barcode'),
            'tax_perchantage' => $this->request->getVar('tax_perchantage12'),
            'productinitial_quantity' => $this->request->getVar('productinitial_quantity'),
            'buying_unit_price' => $this->request->getVar('buying_unit_price'),
            'selling_unit_price' => $this->request->getVar('selling_unit_price'),
            'alert_quantity' => $this->request->getVar('alert_quantity'),
            //'product_image'     => $this->request->getVar('product_image')

        ];
        //$id = $this->NewProductAddModel->insert($data);
        $id = $this->NewProductAddModel_Object->update($id, $data);
        if ($id > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }


    // public function openingStockForm()
    // {
    //     return view('product/modal_opening_stock');
    // }




    public function delete($id = 0)
    {
        // Get delete_id from POST request
        $id = $this->request->getPost('delete_id'); // safer than getVar() for POST form

        if ($id) {
            // Delete product from database
            $this->NewProductAddModel_Object->where('product_id', $id)->delete();

            // Optional: set a flash message
            session()->setFlashdata('msg', 'Product deleted successfully.');
        } else {
            session()->setFlashdata('msg', 'Invalid product ID.');
        }

        // Redirect back to product list page
        return redirect()->to(site_url('/product'));
    }

    public function brand_call()
    {
        $categoryId = $_POST['categoryId'];
        $builder = $this->db->table('product_brand');
        $builder->where('product_category_id', $categoryId);
        $query = $builder->get();
        $results = $query->getResult();
        echo '<option value="">Select Brand</option>';
        foreach ($results as $row) {
            $brand_id = $row->brand_id;
            $product_brand_name = $row->product_brand_name;
            echo "<option value='$brand_id'>$product_brand_name</option>";
        }
    }

    public function barcodegenerate()
    {

        //$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

        //echo $generator->getBarcode('rasel', $generator::TYPE_CODE_128);

        // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';
    }



public function categoryCreateAjax()
{
    $model = new ProductCategoryModel();

    $data = [
        'category_name' => $this->request->getPost('category_name')
    ];

    $id = $model->insert($data);

    return $this->response->setJSON([
        'status' => true,
        'id' => $id,
        'name' => $data['category_name']
    ]);
}



public function getCategoryList()
{

   // echo "getCategoryList";
    $model = new ProductCategoryModel();

    $data = $model
            ->select('product_category_id, category_name')
            ->orderBy('category_name','ASC')
            ->findAll();

    return $this->response->setJSON($data);
}

public function brandCreateAjax()
{
    $brandModel = new ProductBrandModel();

    $category_id = $this->request->getPost('category_id');

    
    $brand_name  = trim($this->request->getPost('product_brand_name'));

    if (empty($category_id) || empty($brand_name)) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Category and Brand Name are required.'
        ]);
    }

    // Duplicate Check
    $exists = $brandModel
        ->where('product_category_id', $category_id)
        ->where('LOWER(product_brand_name)', strtolower($brand_name))
        ->first();

    if ($exists) {
        return $this->response->setJSON([
            'status' => false,
            'message' => 'This brand already exists in the selected category.'
        ]);
    }

    $brandModel->insert([
        'product_brand_name'  => $brand_name,
        'product_category_id' => $category_id
      
    ]);

    return $this->response->setJSON([
        'status' => true,
        'id'     => $brandModel->getInsertID(),
        'name'   => $brand_name
    ]);
}


public function groupCreateAjax()
{
    $model = new ProductGroupModel();

    $data = [
        'group_name' => $this->request->getPost('group_name')
    ];

    $id = $model->insert($data);

    return $this->response->setJSON([
        'status' => true,
        'id' => $id,
        'name' => $data['group_name']
    ]);
}


public function unitCreateAjax()
{
    $model = new ProductUnitModel();

    $data = [
        'product_unit_name' => $this->request->getPost('product_unit')
    ];

    $id = $model->insert($data);

    return $this->response->setJSON([
        'status' => true,
        'id' => $id,
        'name' => $data['product_unit_name']
    ]);
}




}

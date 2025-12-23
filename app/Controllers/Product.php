<?php

namespace App\Controllers;

use App\Models\NewProductAddModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductBrandModel;
use App\Models\ProductGroupModel;
use App\Models\ProductUnitModel;

use App\Models\TaxModel;

//use Picqer\Barcode;
//use Picqer\Barcode\BarcodeGeneratorPNG;


use CodeIgniter\HTTP\IncomingRequest;

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
      $this->NewProductAddModel_Object   = new NewProductAddModel();
      $this->productCategory_object = new ProductCategoryModel();
      $this->ProductBrandModel    = new ProductBrandModel();
      $this->productgroup_object  = new ProductGroupModel();
      $this->productunit_object   = new ProductUnitModel();
      $this->tax_object = new TaxModel();
      //$this->db = \Config\Database::connect();
      $this->db = db_connect();
   }

   public function index()
   {
      $data['category_show'] = $this->productCategory_object->findAll();
      $data['brand_show']    = $this->ProductBrandModel->findAll();
      $data['group_show']    = $this->productgroup_object->findAll();
      $data['unit_show']     = $this->productunit_object->findAll();
      $data['tax_show']      = $this->tax_object->findAll();

      $sql = "SELECT * FROM product_inital_stock AS pr
      JOIN product_category AS pc ON pr.product_category=pc.product_category_id
      JOIN product_group as pg ON pr.product_group =  pg.product_group_id
      JOIN product_brand as pb ON pr.product_brand =  pb.brand_id
      JOIN product_unit as pu ON pr.product_unit =  pu.product_unit_id";

      $data['product_show'] = $this->db->query($sql)->getResult('array');

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

      ////////////////////////////////////////////////////////////////////////

      $data = [
         'product_name'            => $this->request->getVar('product_name'),
         'product_category'        => $this->request->getVar('product_category'),
         'product_brand'           => $this->request->getVar('product_brand'),
         'product_group'           => $this->request->getVar('product_group'),
         'product_unit'            => $this->request->getVar('product_unit'),
         'codefor_barcode'         => $this->request->getVar('codefor_barcode'),
         'tax_perchantage'         => $this->request->getVar('tax_perchantage'),
         'productinitial_quantity' => $this->request->getVar('productinitial_quantity'),
         'buying_unit_price'       => $this->request->getVar('buying_unit_price'),
         'selling_unit_price'      => $this->request->getVar('selling_unit_price'),
         'alert_quantity'          => $this->request->getVar('alert_quantity'),
         // 'product_image'           => $this->request->getVar('product_image')
         'product_image' =>  $avatar->getClientName()

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
      $data = [
         'product_name'       => $this->request->getVar('product_name'),
         'product_category'   => $this->request->getVar('product_category12'),
         'product_brand'      => $this->request->getVar('product_brand12'),
         'product_group'      => $this->request->getVar('product_group12'),
         'product_unit'       => $this->request->getVar('product_unit12'),
         'codefor_barcode'    => $this->request->getVar('codefor_barcode'),
         'tax_perchantage'    => $this->request->getVar('tax_perchantage12'),
         'productinitial_quantity' => $this->request->getVar('productinitial_quantity'),
         'buying_unit_price'       => $this->request->getVar('buying_unit_price'),
         'selling_unit_price'      => $this->request->getVar('selling_unit_price'),
         'alert_quantity'     => $this->request->getVar('alert_quantity')
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

   public function delete($id = 0)
   {
      $id = $this->request->getVar('delete_id');
      $this->NewProductAddModel_Object->where('product_id', $id)->delete();
      return $this->response->redirect(site_url('/Product'));
   }

   public function brand_call()
   {
      $categoryId = $_POST['categoryId'];
      $builder = $this->db->table('product_brand');
      $builder->where('product_category_id', $categoryId);
      $query   = $builder->get();
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
}

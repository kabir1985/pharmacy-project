<?php

namespace App\Controllers;

use App\Models\ProductBrandModel;
use App\Models\ProductCategoryModel;

class ProductBrandController extends BaseController
{
    protected ProductBrandModel $product_brand_object;
    protected ProductCategoryModel $product_category_object;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->product_brand_object = new ProductBrandModel();
        $this->product_category_object = new ProductCategoryModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {

        $data['category_show'] = $this->product_category_object->findAll();
        $data['brand_show'] = $this->product_brand_object->findAll();

        $data['product_brand_show'] = $this->db
            ->table('product_brand pb')
            ->select('pb.*, pc.category_name')
            ->join('product_category pc', 'pb.product_category_id = pc.product_category_id')
            ->orderBy('pb.brand_id', 'DESC')
            ->get()
            ->getResultArray();

        return view('product/ProductBrandAdd', $data);
    }

    //--------------------------------------------------------------------//
    public function create()
    {

        $brandName = trim($this->request->getPost('product_brand_name'));
        $categoryId = (int) $this->request->getPost('product_category_id');

        if ($brandName === '') {
            return redirect()->back()->with('error', 'Brand name is required.');
        }

        $exists = $this->product_brand_object
            ->where('product_category_id', $categoryId)
            ->where('product_brand_name', $brandName)
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Brand already exists.');
        }

        $data = [
            'product_brand_name' => $brandName,
            'product_category_id' => $categoryId,
        ];

        $id = $this->product_brand_object->insert($data);

        if ($id > 0) {
            // Redirect to category list page
            return redirect()->to(site_url('/productbrandView'));
        } else {
            // Redirect back with error message
            return redirect()->back()->with('error', 'Product Brand creation failed');
        }

    }

    //--------------------------------------------------------------------//
    public function update($id = 0)
    {
        $id = (int) $this->request->getPost('product_brand_id');
        $categoryId = (int) $this->request->getPost('product_category_id');
        $brandName = trim($this->request->getPost('product_brand_name'));
    
        // Validation
        if ($id <= 0 || $categoryId <= 0 || $brandName === '') {
            return redirect()
                ->back()
                ->with('error', 'Category and Brand Name are required.');
        }
    
        // Duplicate Check
        $exists = $this->product_brand_object
            ->where('product_category_id', $categoryId)
            ->where('product_brand_name', $brandName)
            ->where('brand_id !=', $id)
            ->first();
    
        if ($exists) {
            return redirect()
                ->back()
                ->with('error', 'Brand already exists.');
        }
    
        // Update
        $updated = $this->product_brand_object->update($id, [
            'product_brand_name' => $brandName,
            'product_category_id' => $categoryId,
        ]);
    
        if ($updated) {
            return redirect()
                ->to(site_url('/productbrandView'))
                ->with('success', 'Product Brand updated successfully.');
        }
    
        return redirect()
            ->back()
            ->with('error', 'Product Brand update failed.');
    }
    //--------------------------------------------------------------------//
    public function delete($id = 0)
    {

       // $id = $this->request->getVar('delete_id');
        $id = (int) $this->request->getPost('delete_id');

       // $this->product_brand_object->where('brand_id', $id)->delete();
        $this->product_brand_object->delete($id);

        //return into Brand page
        return $this->response->redirect(site_url('/productbrandView'));
    }

    public function brand_call()
    {
        $categoryId = (int) $this->request->getPost('categoryId');
    
        $brands = $this->product_brand_object
            ->select('brand_id, product_brand_name')
            ->where('product_category_id', $categoryId)
            ->orderBy('product_brand_name', 'ASC')
            ->findAll();
    
        echo '<option value="">Select Brand</option>';
    
        foreach ($brands as $brand) {
            echo '<option value="' . $brand['brand_id'] . '">'
                . esc($brand['product_brand_name'])
                . '</option>';
        }
    }

    public function brandCreateAjax()
    {
        $categoryId = (int) $this->request->getPost('category_id');
        $brandName  = trim($this->request->getPost('product_brand_name'));
    
        // Validation
        if ($categoryId <= 0 || $brandName === '') {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Category and Brand Name are required.',
            ]);
        }
    
        // Duplicate Check
        $exists = $this->product_brand_object
            ->where('product_category_id', $categoryId)
            ->where('product_brand_name', $brandName)
            ->first();
    
        if ($exists) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'This brand already exists in the selected category.',
            ]);
        }
    
        // Insert
        $id = $this->product_brand_object->insert([
            'product_brand_name' => $brandName,
            'product_category_id' => $categoryId,
        ]);
    
        if (!$id) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Unable to add brand.',
            ]);
        }
    
        return $this->response->setJSON([
            'status'  => true,
            'id'      => $id,
            'name'    => $brandName,
            'message' => 'Brand added successfully.',
        ]);
    }

}

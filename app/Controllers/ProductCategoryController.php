<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;

class ProductCategoryController extends BaseController
{
    protected ProductCategoryModel $productCategory_object;

    public function __construct()
    {
        $this->productCategory_object = new ProductCategoryModel();
    }

    public function index()
    {
        $data['category_show'] = $this->productCategory_object->findAll();

        return view('product/ProductCategoryAdd', $data);
    }

    //--------------------------------------------------------------------//
    public function create()
    {
        $categoryName = trim($this->request->getPost('product_category_name'));

        $exists = $this->productCategory_object
            ->where('category_name', $categoryName)
            ->first();

        if ($exists) {
            return redirect()
                ->back()
                ->with('error', 'Category already exists.');
        }

        $id = $this->productCategory_object->insert([
            'category_name' => $categoryName,
        ]);

        if ($id) {
            return redirect()->to(site_url('categories'));
        }

        return redirect()
            ->back()
            ->with('error', 'Category creation failed.');
    }

    //--------------------------------------------------------------------//
    public function update($id = 0)
    {
        $id = (int) $this->request->getPost('product_category_id');
        $categoryName = trim($this->request->getPost('category_name'));

        // Validation
        if ($categoryName === '') {
            return redirect()
                ->back()
                ->with('error', 'Category name is required.');
        }

        // Duplicate check (except current record)
        $exists = $this->productCategory_object
            ->where('category_name', $categoryName)
            ->where('product_category_id !=', $id)
            ->first();

        if ($exists) {
            return redirect()
                ->back()
                ->with('error', 'Category already exists.');
        }

        $updated = $this->productCategory_object->update($id, [
            'category_name' => $categoryName,
        ]);

        if ($updated) {
            return redirect()->to(site_url('categories'))
                ->with('success', 'Category updated successfully.');
        }

        return redirect()
            ->back()
            ->with('error', 'Category update failed.');
    }

    public function delete($id = 0)
    {

        $id = (int) $this->request->getPost('delete_id');

        $this->productCategory_object->delete($id);

        return redirect()
            ->to(site_url('categories'))
            ->with('success', 'Category deleted successfully.');
    }

    public function categoryCreateAjax()
    {
        $categoryName = trim($this->request->getPost('category_name'));

        // Empty validation
        if ($categoryName === '') {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Category name is required.',
            ]);
        }

        // Duplicate check
        $exists = $this->productCategory_object
            ->where('category_name', $categoryName)
            ->first();

        if ($exists) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Category already exists.',
            ]);
        }

        // Insert
        $id = $this->productCategory_object->insert([
            'category_name' => $categoryName,
        ]);

        return $this->response->setJSON([
         'status'  => true,
         'id'      => $id,
         'name'    => $categoryName,
         'message' => 'Category added successfully.',
     ]);
    }

    public function getCategoryList()
    {

        $data = $this->productCategory_object
            ->select('product_category_id, category_name')
            ->orderBy('category_name', 'ASC')
            ->findAll();

        return $this->response->setJSON($data);
    }

}

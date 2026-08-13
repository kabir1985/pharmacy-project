<?php

namespace App\Controllers;

use App\Models\ProductBrandModel;

class ProductBrandController extends BaseController
{
    protected ProductBrandModel $product_brand_object;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->product_brand_object = new ProductBrandModel();
        $this->db = \Config\Database::connect();
    }

    // ==========================================================
    // BRAND LIST
    // ==========================================================

    public function index()
    {
        $data['product_brand_show'] = $this->product_brand_object
            ->orderBy('brand_id', 'DESC')
            ->findAll();

        return view('product/ProductBrandAdd', $data);
    }


    // ==========================================================
    // CREATE BRAND
    // ==========================================================

    public function create()
    {
        $brandName = trim(
            $this->request->getPost('product_brand_name')
        );

        // Validation
        if ($brandName === '') {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Brand name is required.');
        }

        // Duplicate check
        $exists = $this->product_brand_object
            ->where('product_brand_name', $brandName)
            ->first();

        if ($exists) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'This brand already exists.'
                );
        }

        // Insert
        $id = $this->product_brand_object->insert([
            'product_brand_name' => $brandName
        ]);

        if ($id) {

            return redirect()
                ->to(site_url('brands'))
                ->with(
                    'success',
                    'Brand added successfully.'
                );
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'Product Brand creation failed.'
            );
    }


    // ==========================================================
    // UPDATE BRAND
    // ==========================================================

    public function update()
    {
        $brandId = (int) $this->request->getPost('product_brand_id');

        $brandName = trim(
            $this->request->getPost('product_brand_name')
        );

        if ($brandId <= 0 || $brandName === '') {

            return redirect()
                ->back()
                ->with('error', 'Invalid brand information.');
        }

        // Check duplicate except current brand
        $exists = $this->product_brand_object
            ->where('product_brand_name', $brandName)
            ->where('brand_id !=', $brandId)
            ->first();

        if ($exists) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'This brand already exists.'
                );
        }

        $updated = $this->product_brand_object
            ->update(
                $brandId,
                [
                    'product_brand_name' => $brandName
                ]
            );

        if ($updated) {

            return redirect()
                ->to(site_url('brands'))
                ->with(
                    'success',
                    'Brand updated successfully.'
                );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'Brand update failed.'
            );
    }


    // ==========================================================
    // DELETE BRAND
    // ==========================================================

    public function delete()
    {
        $brandId = (int) $this->request->getPost('delete_id');

        if ($brandId <= 0) {

            return redirect()
                ->back()
                ->with('error', 'Invalid brand ID.');
        }

        $deleted = $this->product_brand_object
            ->delete($brandId);

        if ($deleted) {

            return redirect()
                ->to(site_url('brands'))
                ->with(
                    'success',
                    'Brand deleted successfully.'
                );
        }

        return redirect()
            ->back()
            ->with(
                'error',
                'Brand deletion failed.'
            );
    }


public function brandCreateAjax()
{
    $brandName = trim(
        $this->request->getPost('product_brand_name')
    );

    if ($brandName === '') {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Brand name is required.'
        ]);
    }

    // Prevent duplicate brand
    $existing = $this->product_brand_object
        ->where('product_brand_name', $brandName)
        ->first();

    if ($existing) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'This brand already exists.'
        ]);
    }

    $brandId = $this->product_brand_object->insert([
        'product_brand_name' => $brandName
    ]);

    if (!$brandId) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Unable to create brand.'
        ]);
    }

    return $this->response->setJSON([
        'status' => true,
        'id'     => $brandId,
        'name'   => $brandName
    ]);
}


}
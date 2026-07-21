<?php

namespace App\Controllers;

use App\Models\ProductUnitModel;
use Exception;

class ProductUnitController extends BaseController
{
    private ProductUnitModel $productunit_object;

    public function __construct()
    {
        $this->productunit_object = new ProductUnitModel();
    }

    public function index()
    {
        $data['unit_show'] = $this->productunit_object
            ->orderBy('product_unit_name', 'ASC')
            ->findAll();

        return view('product/ProductUnitAdd', $data);
    }

    /**
     * Create Product Unit
     */
    public function create()
    {
        $rules = [
            'product_unit' => [
                'label' => 'Product Unit',
                'rules' => 'required|min_length[2]|max_length[100]|is_unique[product_unit.product_unit_name]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {

            $insertId = $this->productunit_object->insert([
                'product_unit_name' => trim($this->request->getPost('product_unit')),
            ]);

            if (! $insertId) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Unable to create product unit.');
            }

            return redirect()
                ->to(site_url('units'))
                ->with('success', 'Product unit added successfully.');

        } catch (Exception $e) {

            log_message('error', 'Product Unit Create Error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Update Product Unit
     */
    public function update()
    {
        $rules = [
            'product_unit_id' => 'required|integer',
            'product_unit_name' => 'required|min_length[2]|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {

            $id = (int) $this->request->getPost('product_unit_id');

            $updated = $this->productunit_object->update($id, [
                'product_unit_name' => trim($this->request->getPost('product_unit_name')),
            ]);

            if (! $updated) {
                return redirect()
                    ->back()
                    ->with('error', 'Unable to update product unit.');
            }

            return redirect()
                ->to(site_url('units'))
                ->with('success', 'Product unit updated successfully.');

        } catch (Exception $e) {

            log_message('error', 'Product Unit Update Error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Delete Product Unit
     */
    public function delete()
    {
        $rules = [
            'delete_id' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->with('error', 'Invalid product unit.');
        }

        try {

            $id = (int) $this->request->getPost('delete_id');

            if (! $this->productunit_object->delete($id)) {
                return redirect()
                    ->back()
                    ->with('error', 'Unable to delete product unit.');
            }

            return redirect()
                ->to(site_url('units'))
                ->with('success', 'Product unit deleted successfully.');

        } catch (Exception $e) {

            log_message('error', 'Product Unit Delete Error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Ajax Create Product Unit
     */
    public function unitCreateAjax()
    {
        $rules = [
            'product_unit' => [
                'label' => 'Product Unit',
                'rules' => 'required|min_length[2]|max_length[100]|is_unique[product_unit.product_unit_name]',
            ],
        ];

        if (! $this->validate($rules)) {

            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->validator->getErrors(),
                ]);
        }

        try {

            $name = trim($this->request->getPost('product_unit'));

            $id = $this->productunit_object->insert([
                'product_unit_name' => $name,
            ]);

            if (! $id) {

                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Unable to create product unit.',
                    ]);
            }

            return $this->response->setJSON([
                'status' => true,
                'id'     => $id,
                'name'   => $name,
            ]);

        } catch (Exception $e) {

            log_message('error', 'Ajax Product Unit Create Error: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => false,
                    'message' => 'Something went wrong.',
                ]);
        }
    }
}
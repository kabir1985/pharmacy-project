<?php

namespace App\Controllers;

use App\Models\ProductStrengthModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductStrengthController extends BaseController
{
    protected ProductStrengthModel $strengthModel;

    public function __construct()
    {
        $this->strengthModel = new ProductStrengthModel();
    }

    /**
     * Create Product Strength (AJAX)
     *
     * @return ResponseInterface
     */
    public function strengthCreateAjax(): ResponseInterface
    {
        $rules = [
            'strength' => [
                'label' => 'Strength',
                'rules' => 'required|max_length[100]'
            ]
        ];

        if (! $this->validate($rules)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Validation failed.',
                    'errors'  => $this->validator->getErrors()
                ]);
        }

        try {

            $strength = trim($this->request->getPost('strength'));

            // Case-insensitive duplicate check
            $exists = $this->strengthModel
                ->where('LOWER(strength_name)', strtolower($strength))
                ->first();

            if ($exists) {
                return $this->response->setJSON([
                    'status'  => true,
                    'id'      => $exists['strength_id'],
                    'name'    => $exists['strength_name'],
                    'message' => 'Strength already exists.'
                ]);
            }

            $id = $this->strengthModel->insert([
                'strength_name' => $strength
            ]);

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_CREATED)
                ->setJSON([
                    'status'  => true,
                    'id'      => $id,
                    'name'    => $strength,
                    'message' => 'Strength added successfully.'
                ]);

        } catch (\Throwable $e) {

            log_message('error', $e->getMessage());

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Something went wrong. Please try again.'
                ]);
        }
    }
}
<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    private $user_model_object;
    private $db;

    public function __construct()
    {
        $this->user_model_object = new UserModel();
        $this->db = db_connect();
    }

    public function index()
    {
        $data['user_show'] = $this->db->table('user')
            ->select('
                user.user_id,
                user.user_name,
                user.user_email,
                user.login_id,
                user_role.user_role_id,
                user_role.role_holder
            ')
            ->join('user_role', 'user_role.user_role_id = user.user_role_id', 'left')
            ->orderBy('user.user_name', 'ASC')
            ->get()
            ->getResultArray();

        $data['roles'] = $this->db
            ->table('user_role')
            ->select('user_role_id,role_holder')
            ->orderBy('role_holder')
            ->get()
            ->getResultArray();

        return view('user/user_add', $data);
    }

    //--------------------------------------------------------------------//
    public function create()
    {
        $rules = [
            'user_name' => 'required|max_length[100]',
            'user_email' => 'required|valid_email|max_length[100]',
            'login_id' => 'required|max_length[80]',
            'login_password' => 'required|min_length[6]',
            'user_role_id' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'validation',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $loginId = trim($this->request->getVar('login_id'));

        // Check duplicate login ID
        $exists = $this->user_model_object
            ->where('login_id', $loginId)
            ->first();

        if ($exists) {
            return $this->response->setJSON([
                'status' => 'exists',
                'message' => 'Login ID already exists.',
            ]);
        }

        $data = [
            'user_name' => trim($this->request->getVar('user_name')),
            'user_email' => trim($this->request->getVar('user_email')),
            'login_id' => $loginId,
            'login_password' => password_hash(
                $this->request->getVar('login_password'),
                PASSWORD_DEFAULT
            ),
            'user_role_id' => (int) $this->request->getVar('user_role_id'),
        ];

        if ($this->user_model_object->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User created successfully.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Unable to save user.',
        ]);
    }

    //--------------------------------------------------------------------//
    public function update($id = 0)
    {
        $id = (int) $this->request->getVar('user_id');

        $rules = [
            'user_name' => 'required|max_length[100]',
            'user_email' => 'required|valid_email|max_length[100]',
            'login_id' => 'required|max_length[80]',
            'user_role_id_edit' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'validation',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $password = trim((string) $this->request->getVar('login_password'));

        $data = [
            'user_name' => trim($this->request->getVar('user_name')),
            'user_email' => trim($this->request->getVar('user_email')),
            'login_id' => trim($this->request->getVar('login_id')),
            'user_role_id' => (int) $this->request->getVar('user_role_id_edit'),
        ];

        // Update password only if entered
        if ($password !== '') {
            $data['login_password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Check duplicate Login ID
        $exists = $this->user_model_object
            ->where('login_id', $data['login_id'])
            ->where('user_id !=', $id)
            ->first();

        if ($exists) {
            return $this->response->setJSON([
                'status' => 'exists',
                'message' => 'Login ID already exists.',
            ]);
        }

        $updated = $this->user_model_object->update($id, $data);

        if ($updated) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'User updated successfully.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Unable to update user.',
        ]);
    }

    public function delete()
    {
        $id = (int) $this->request->getPost('delete_id');
    
        // Invalid ID
        if ($id <= 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Invalid user selected.'
            ]);
        }
    
        // Prevent deleting your own account
        if ((int) session()->get('user_id') === $id) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'You cannot delete your own account.'
            ]);
        }
    
        // Check if user exists
        if (! $this->user_model_object->find($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'User not found.'
            ]);
        }
    
        try {
    
            if ($this->user_model_object->delete($id)) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'User deleted successfully.'
                ]);
            }
    
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Unable to delete user.'
            ]);
    
        } catch (\Exception $e) {
    
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'This user cannot be deleted because it is used by other records.'
            ]);
    
        }
    }
}

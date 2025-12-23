<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db      = db_connect();
        $this->session = session();
    }

    public function index()
    {
        // return view('login_form'); // your login view

        // if (!$this->session->get('isLoggedIn'))
        //     {
        //     return redirect()->to(site_url('login'));
        //    }

        return view('login/login_form');
    }

    // echo "<pre>";

    // Handle AJAX login
    public function auth()
    {
        $login_id = $this->request->getPost('username');
        $login_pw = $this->request->getPost('password');

        $builder = $this->db->table('user');
        $builder->where('login_id', $login_id);
        $query  = $builder->get();
        $result = $query->getRow();

        if ($result) {
            if ($login_pw === $result->login_password) {
                session()->set([
                    'user_id'      => $result->user_id,
                    'login_id'     => $result->login_id,
                    'user_role_id' => $result->user_role_id,
                    'isLoggedIn'   => true,
                ]);

                // Get and store allowed menus in session
                $allowedMenus = $this->getUserPrivileges();
                $this->session->set('allowedMenus', $allowedMenus);

                return $this->response->setJSON(['status' => 'success', 'redirect' => site_url('dashboard')]);

            } else {
                return $this->response->setJSON(['status' => 'error', 'redirect' => site_url('login')]);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'Invalid username or password']);
        }

    }

    private function getUserPrivileges()
    {
        $role_id = $this->session->get('user_role_id');
        if (! $role_id) {
            return [];
        }

        $role = $this->db->table('user_role')
            ->where('user_role_id', $role_id)
            ->get()
            ->getRow();

        if (! $role) {
            return [];
        }

        $menu_ids = explode(',', $role->user_previlege);
        $menus    = $this->db->table('menu_id')
            ->whereIn('menu_id', $menu_ids)
            ->get()
            ->getResultArray();

        return array_column($menus, 'menu_name');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}
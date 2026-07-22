<?php
namespace App\Controllers;

class LoginController extends BaseController
{

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
    }

    public function index()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('login/login_form');
    }

    public function auth()
    {

        $login_id = trim((string) $this->request->getPost('username'));
        $login_pw = (string) $this->request->getPost('password');

        if ($login_id === '' || $login_pw === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'Username and password are required.',
            ]);
        }

        $result = $this->db
            ->table('user')
            ->select('user_id, login_id, login_password, user_role_id, user_name')
            ->where('login_id', $login_id)
            ->limit(1)
            ->get()
            ->getRow();

        if ($result) {
            //if ($login_pw === $result->login_password) {
            if (password_verify($login_pw, $result->login_password)) {

                $this->session->regenerate();
                $this->session->set([
                    'user_id' => $result->user_id,
                    'login_id' => $result->login_id,
                    'user_role_id' => $result->user_role_id,
                    'user_name' => $result->user_name,
                    'isLoggedIn' => true,
                    'login_time' => date('Y-m-d H:i:s'),
                ]);

                // Get and store allowed menus in session
                $allowedMenus = $this->getUserPrivileges();
                $this->session->set('allowedMenus', $allowedMenus);

                return $this->response->setJSON(['status' => 'success', 'redirect' => site_url('dashboard')]);

            } else {
                //return $this->response->setJSON(['status' => 'error', 'redirect' => site_url('login')]);
                return $this->response->setJSON([
                    'status' => 'error',
                    'msg' => 'Invalid username or password',
                ]);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'msg' => 'Invalid username or password']);
        }

    }

    private function getUserPrivileges()
    {
        $role_id = $this->session->get('user_role_id');

        if (!$role_id) {
            return [];
        }

        $role = $this->db->table('user_role')
            ->select('user_previlege')
            ->where('user_role_id', $role_id)
            ->get()
            ->getRow();

        if (!$role || empty($role->user_previlege)) {
            return [];
        }

        $menu_ids = array_filter(array_map('trim', explode(',', $role->user_previlege)));

        if ($menu_ids === []) {
            return [];
        }

        $menus = $this->db->table('menu_id')
            ->select('menu_name')
            ->whereIn('menu_id', $menu_ids)
            ->get()
            ->getResultArray();

        return array_column($menus, 'menu_name');
    }

    public function logout()
    {

        $this->session->destroy();

        return redirect()->to(site_url('login'));
    }
}

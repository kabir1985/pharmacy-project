<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class Dashboard extends BaseController
{
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->db      = db_connect();
        $this->session = Services::session();
    }

    public function index()
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        $allowedMenus = $this->session->get('allowedMenus') ?? [];

        return view('ViewDashboard', [
            'allowedMenus' => $allowedMenus,
        ]);
    }
}

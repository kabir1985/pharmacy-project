<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();

        // Optional: redirect to login if not logged in
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }
    }

    public function index()
    {
        // Retrieve allowed menus from session
        $allowedMenus = $this->session->get('allowedMenus');

        return view('ViewDashboard', [
            'allowedMenus' => $allowedMenus,
        ]);
    }
}

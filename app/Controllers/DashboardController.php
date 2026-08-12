<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use Config\Services;

class DashboardController extends BaseController
{
    protected $session;
    protected DashboardModel $dashboardModel;


    public function __construct()
    {
        $this->session = Services::session();

        $this->dashboardModel = new DashboardModel();
    }


    public function index()
    {
        // ==================================================
        // Allowed Menus
        // ==================================================

        $allowedMenus = $this->session->get('allowedMenus') ?? [];


        // ==================================================
        // Dashboard Data
        // ==================================================

        $dashboardData =
            $this->dashboardModel->getDashboardSummary();


        // ==================================================
        // View Data
        // ==================================================

        $data = array_merge(
            [
                'allowedMenus' => $allowedMenus,
            ],
            $dashboardData
        );


        // ==================================================
        // Load Dashboard
        // ==================================================

        return view('ViewDashboard', $data);
    }
}
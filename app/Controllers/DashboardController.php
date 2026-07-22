<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Protect all dashboard routes
        (new AuthMiddleware())->handle();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Overview',
            'breadcrumb' => [
                ['name' => 'Dashboard', 'url' => url('dashboard'), 'active' => true]
            ]
        ];
        $this->view('dashboard.index', $data);
    }
}

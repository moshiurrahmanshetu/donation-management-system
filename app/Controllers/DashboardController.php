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
            'title' => 'Dashboard',
            'user' => [
                'username' => $_SESSION['username'] ?? 'User',
                'role' => $_SESSION['user_role'] ?? 'user'
            ],
            'system_status' => 'Online',
            'quick_cards' => [
                ['title' => 'Total Donations', 'value' => '$0', 'icon' => 'bi-cash-coin', 'color' => 'primary'],
                ['title' => 'Total Donors', 'value' => '0', 'icon' => 'bi-people', 'color' => 'success'],
                ['title' => 'Active Campaigns', 'value' => '0', 'icon' => 'bi-megaphone', 'color' => 'info']
            ]
        ];
        $this->view('dashboard.index', $data);
    }
}

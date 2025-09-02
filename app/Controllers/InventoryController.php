<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class InventoryController extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Inventory Dashboard',
            'user' => [
                'fullName' => session()->get('fullName'),
                'role' => session()->get('role'),
                'username' => session()->get('username')
            ],
            'stats' => [
                'medicinesInStock' => 0,
                'lowStockItems' => 0,
                'expiringSoon' => 0,
            ],
        ];

        return view('inventory/dashboard', $data);
    }

    public function manage()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('inventory/manage');
    }

    public function lowStock()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('inventory/low_stock');
    }

    public function expiring()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('inventory/expiring');
    }

    public function reports()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('inventory/reports');
    }
}

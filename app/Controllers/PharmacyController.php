<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PharmacyController extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Placeholder stats; replace with real queries when models/tables are ready
        $data = [
            'title' => 'Pharmacist Dashboard',
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
            'pendingPrescriptions' => [],
        ];

        return view('pharmacy/dashboard', $data);
    }

    public function dispense()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('pharmacy/dispense');
    }

    public function prescriptions()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('pharmacy/prescriptions');
    }

    public function reports()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('pharmacy/reports');
    }

    public function lookup()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('pharmacy/lookup');
    }
}

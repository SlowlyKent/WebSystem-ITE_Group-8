<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ReceptionistController extends Controller
{
    public function index()
    {
        $session = session();

        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Only allow receptionist
        if ($session->get('role') !== 'receptionist') {
            throw \CodeIgniter\Exceptions\PageForbiddenException::forPageForbidden();
        }

        // Data to send to the view
        $data = [
            'title' => 'Receptionist Dashboard',
            'user'  => [
                'fullName' => $session->get('fullName'),
                'role'     => $session->get('role'),
            ],
            'stats' => [
                'totalPatients'    => 0, // Replace with real DB query later
                'totalAppointments'=> 0,
                'pendingPayments'  => 0,
            ],
        ];

        return view('receptionist/dashboard', $data);
    }
}
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login to access this page');
<<<<<<< HEAD
            return redirect()->to(base_url('login'));
=======
            return redirect()->to('/login');
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
        }

        // Check if user account is active
        if (session()->get('status') === 'inactive') {
            session()->destroy();
            session()->setFlashdata('error', 'Your account has been deactivated. Please contact administrator.');
<<<<<<< HEAD
            return redirect()->to(base_url('login'));
=======
            return redirect()->to('/login');
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after the request
    }
}

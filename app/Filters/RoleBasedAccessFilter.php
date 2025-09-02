<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleBasedAccessFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login to access this page');
            return redirect()->to('/login');
        }

        // Check role-based access
        if ($arguments !== null) {
            $userRole = session()->get('role');
            $allowedRoles = is_array($arguments) ? $arguments : [$arguments];

            if (!in_array($userRole, $allowedRoles)) {
                session()->setFlashdata('error', 'Access denied. Insufficient permissions.');
                return redirect()->to('/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after the request
    }
}

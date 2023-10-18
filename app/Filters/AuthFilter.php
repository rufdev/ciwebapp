<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper("auth");
        if (!auth()->loggedIn()) {
            return redirect()->to(base_url('login'));
        }
    }
  
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}

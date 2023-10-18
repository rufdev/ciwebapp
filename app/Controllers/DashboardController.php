<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\Response;

class DashboardController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $author = new \App\Models\Author();
        $totalauthors = $author->select('id')->countAllResults();

        $data = [
            'totalauthors' => $totalauthors
        ];
        return view('dashboard/index',$data);
    }
}

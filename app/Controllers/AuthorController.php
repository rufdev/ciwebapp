<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\Response;

class AuthorController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return view('authors/index');
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $author = new \App\Models\Author();
        $data = $author->find($id);
        return $this->response->setJSON($data);
    }

    public function getall() {
        $request = service('request');
        $postData = $request->getPost();
    
        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $searchValue = $postData['search']['value']; // Search value
        $sortby = $postData['order'][0]['column']; // Sort column index
        $sortdir = $postData['order'][0]['dir']; // Sort direction
        $sortcolumn = $postData['columns'][$sortby]['data']; // Sort column name
        
        ## Total number of records without filtering
        $author = new \App\Models\Author();
        $totalRecords = $author->select('id')->countAllResults();

        ## Total number of records with filtering
        $totalRecordwithFilter = $author->select('id')
            ->orLike('last_name', $searchValue)
            ->orLike('first_name', $searchValue)
            ->orLike('email', $searchValue)
            ->countAllResults();

        ## Fetch records
        $records = $author->select('*')
            ->orLike('last_name', $searchValue)
            ->orLike('first_name', $searchValue)
            ->orLike('email', $searchValue)
            ->orderBy($sortcolumn, $sortdir)
            ->findAll($rowperpage, $start);

        $data = array();

        foreach ($records as $record) {

            $data[] = array(
                "id" => $record['id'],
                "last_name" => $record['last_name'],
                "first_name" => $record['first_name'],
                "email" => $record['email'],
                "birthdate" => $record['birthdate']
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordwithFilter,
            "data" => $data,
            "token" => csrf_hash() // New token hash
        );
        return $this->response->setJSON($response);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $author = new \App\Models\Author();
        $data = $this->request->getJSON();

        if(!$author->validate($data)){
            $response = array(
                "status" => "error",
                "message" => $author->errors(),
                "token" => csrf_hash()
            );

            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $author->insert($data);
        $response = array(
            "status" => "success",
            "message" => "Author created successfully",
            "token" => csrf_hash()
        );
        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {

        $author = new \App\Models\Author();
        $data = $this->request->getJSON();
        unset($data->id);
       
        if(!$author->validate($data)){
            $response = array(
                "status" => "error",
                "message" => $author->errors(),
                "token" => csrf_hash()
            );

            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_NOT_MODIFIED);
        }

        $author->update($id, $data);
        $response = array(
            "status" => "success",
            "message" => "Author updated successfully",
            "token" => csrf_hash()
        );
        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $author = new \App\Models\Author();

        if ($author->delete($id)) {
            $response = array(
                "status" => "success",
                "message" => "Author deleted successfully",
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
        }

        $response = array(
            "status" => "error",
            "message" => "Author not found",
            "token" => csrf_hash()
        );
        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_NOT_FOUND);
    }
}

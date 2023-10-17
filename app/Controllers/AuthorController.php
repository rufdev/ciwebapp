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
        //
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
        $author = new \App\Models\Author();
        $searchtext = $this->request->getGet('searchtext');    
        
        if($searchtext != null ){
            $data = $author
            ->like('last_name', $searchtext)
            ->orlike('first_name',$searchtext)
            ->findAll();
            return $this->response->setJSON($data);
        }
        
        $data = $author->findAll();
        return $this->response->setJSON($data);
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

<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\Response;

class PostController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $author = new \App\Models\Author();
        $data['authors'] = $author->select('id, CONCAT(first_name," ",last_name) as author_name')->findAll();
        // echo var_dump($data['authors']);
        return view('posts/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $post = new \App\Models\Post();
        $data = $post->find($id);
        return $this->response->setJSON($data);
    }

    public function getall()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $searchValue = $postData['search']['value']; // Search value

        ## Total number of records without filtering
        $post = new \App\Models\Post();
        $totalRecords = $post->select('id')->countAllResults();

        ## Total number of records with filtering
        $totalRecordwithFilter = $post->select('posts.id')
            ->join('authors', 'authors.id = posts.author_id')
            ->orLike('authors.last_name', $searchValue)
            ->orLike('authors.first_name', $searchValue)
            ->orLike('posts.title', $searchValue)
            ->orLike('posts.description', $searchValue)
            ->orLike('posts.content', $searchValue)
            ->orderBy('posts.created_at', 'asc')
            ->countAllResults();

        ## Fetch records
        $records = $post->select("posts.*, CONCAT(authors.first_name,' ', authors.last_name) as author_name")
            ->join('authors', 'authors.id = posts.author_id')
            ->orLike('authors.last_name', $searchValue)
            ->orLike('authors.first_name', $searchValue)
            ->orLike('posts.title', $searchValue)
            ->orLike('posts.description', $searchValue)
            ->orLike('posts.content', $searchValue)
            ->orderBy('posts.created_at', 'asc')
            ->findAll($rowperpage, $start);
        $data = array();

        foreach ($records as $record) {

            $data[] = array(
                "id" => $record['id'],
                "author_name" => $record['author_name'],
                "title" => $record['title'],
                "description" => $record['description'],
                "content" => $record['content'],
                "created_at" => $record['created_at'],
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
        $post = new \App\Models\Post();
        $data = $this->request->getJSON();

        if (!$post->validate($data)) {
            $response = array(
                "status" => "error",
                "message" => $post->errors(),
                "token" => csrf_hash()
            );

            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $post->insert($data);
        $response = array(
            "status" => "success",
            "message" => "post created successfully",
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

        $post = new \App\Models\Post();
        $data = $this->request->getJSON();
        unset($data->id);

        if (!$post->validate($data)) {
            $response = array(
                "status" => "error",
                "message" => $post->errors(),
                "token" => csrf_hash()
            );

            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_NOT_MODIFIED);
        }

        $post->update($id, $data);
        $response = array(
            "status" => "success",
            "message" => "post updated successfully",
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
        $post = new \App\Models\Post();

        if ($post->delete($id)) {
            $response = array(
                "status" => "success",
                "message" => "post deleted successfully",
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
        }

        $response = array(
            "status" => "error",
            "message" => "post not found",
            "token" => csrf_hash()
        );
        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_NOT_FOUND);
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Database\RawSql;

class Home extends BaseController
{
    public function index(): string
    {

        // $db = \Config\Database::connect();
        // $builder = $db->table('authors');

        // $query = $builder->get();
        // $query = $builder->get(10,20);
        // $query = $builder->getWhere(['id' => 1]);
        // $query = $builder->select('id, last_name,email')->getWhere(['id' => 1]); 
        // $sql = "SELECT * FROM authors WHERE id = 1";
        // $query = $builder->selectMax('birthdate')->get();
        // $query = $builder->selectMin('birthdate')->get();
        // $query = $builder->selectAvg('birthdate')->get();
        // $query = $builder->selectSum('birthdate')->get();
        // $query = $builder->selectCount('id')->get();
        // $builder->select('*');
        // $builder->join('posts', 'posts.author_id = authors.id');

        // $builder->where('id', 1);

        // $builder->where('id',1);
        // $builder->orWhere('id',2);
        // $builder->whereIn('id', [1, 2, 3]);
        // $builder->whereNotIn('id', [1, 2, 3]);
        // $builder->like('last_name', 'ming');
        // $builder->orlike('first_name', 'mon');
        
        // $builder->orderBy('last_name', 'ASC');
        // $builder->limit(10);
        // $query = $builder->get();

        // $data = [
        //     'first_name' => 'John',
        //     'last_name' => 'Doe',
        //     'email' => 'johndoe@gmail.com',
        //     'birthdate' => '1980-01-01'
        // ];

        // $builder->insert($data);

        //  $data = [
        //     'first_name' => 'Jane',
        //     'last_name' => 'Doe',
        //     'email' => 'johndoe@gmail.com',
        //     'birthdate' => '1980-01-01'
        // ];

        // $builder->where('id', 103);
        // $builder->update($data);

        // $builder->where('id', 103);
        // $builder->delete();

        // $builder->where('last_name','Doe');
        // $builder->where('first_name','Jane');
        // $query = $builder->getWhere('id',"103");
        // $builder->where('id', 103);
        // $query = $builder->get();

        // $builder->select(new RawSql("SELECT * FROM authors WHERE id = 1"));
        // $query = $builder->get();

        // $sql = $builder->getCompiledSelect();

        // $json = new \stdClass();
        // $json->sql = $sql;

        // $result = $query->getResult();
        // $json->result = $result;

        // echo json_encode($result);



        return view('welcome_message');
    }
}

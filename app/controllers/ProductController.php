<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Request;

class ProductController
{
    public function index()
    {
        $products = App::get('database')->selectAll('products');
        echo Request::response($products);
        exit;
    }

    public function create()
    {
        return view('index');
    }

    public function store()
    {
        $params = (array) json_decode(file_get_contents('php://input'), true); // recive request data as json

        $data = App::get('database')->insert('products', [
            'sku'	=>	$params['sku'],
            'name'	=>	$params['name'],
            'price'	=>	$params['price'],
            'type'	=>	$params['type'],
            'attributes' =>	$params['attributes'] ? $params['attributes'] : null,
        ]);

        echo Request::response($data);
        exit;
    }

    public function delete()
    {
        $params = (array) json_decode(file_get_contents('php://input'), true); // recive request data as json
        $isDeleted = App::get('database')->delete('products', $params['ids']);
        $message = $isDeleted ? 'Deleted Successfully' : 'Not Found';
        $status = $isDeleted ? 200 : 400;

        echo Request::response([
            'message' => $message
        ], $status);
        exit;
    }
}

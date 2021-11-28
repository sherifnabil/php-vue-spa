<?php

$router->get('', 'HomeController@index');
$router->get('add-product', 'HomeController@index');
$router->get('products', 'ProductController@index');
$router->post('product-store', 'ProductController@store');
$router->post('product-delete', 'ProductController@delete');

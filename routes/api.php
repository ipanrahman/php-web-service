<?php

require PATH . "core/Router.php";

$route = new Router(PATH . "controllers/");

// index

$route->get('/', 'HomeController@index');

// users
$route->get("/users", "UserController@index");
$route->post("/users/", "UserController@createUser");
$route->get("/users/{id}", "UserController@getUserById");
$route->put("/users/{id}", "UserController@updateUser");
$route->delete("/users/{id}", "UserController@deleteUser");


// products
$route->get("/products", 'ProductController@getAllProduct');
$route->get("/products/{id}", 'ProductController@getProductById');
$route->get("/products/users/{id}", 'ProductController@getAllProductByUserId');
$route->post("/products", "ProductController@createProduct");
$route->put("/products/{id}", "ProductController@updateProduct");
$route->delete("/products/{id}", "ProductController@deleteProduct");
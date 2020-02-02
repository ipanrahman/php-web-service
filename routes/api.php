<?php

use Libs\Router;

$route = new Router();
$route->setNamespace('\App\Controllers');

// index
$route->get('/', 'HomeController@index');

// Auth Route
$route->post("/api/auth/login", "AuthController@login");
$route->post("/api/auth/register", "AuthController@register");

// users
$route->get("/api/users", "UserController@index");
$route->post("/api/users/", "UserController@createUser");
$route->get("/api/users/{id}", "UserController@getUserById");
$route->put("/api/users/{id}", "UserController@updateUser");
$route->delete("/api/users/{id}", "UserController@deleteUser");


// products
$route->get("/api/products", 'ProductController@getAllProduct');
$route->get("/api/products/{id}", 'ProductController@getProductById');
$route->get("/api/products/users/{id}", 'ProductController@getAllProductByUserId');
$route->post("/api/products", "ProductController@createProduct");
$route->post("/api/products/{id}", "ProductController@updateProduct");
$route->delete("/api/products/{id}", "ProductController@deleteProduct");

// Images Route
$route->get("/images/{fileName}", "ImageController@getImage");

$route->run();
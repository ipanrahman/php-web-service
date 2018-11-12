<?php

require PATH . "core/Router.php";

$route = new Router(PATH . "controllers/");

// index

$route->get('/', 'HomeController@index');

// users
$route->get("/users", "UserController@index");
$route->get("/users/{id}", "UserController@getUserById");
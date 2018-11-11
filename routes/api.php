<?php

require PATH . "core/Router.php";

$route = new Router(PATH . "controllers/");
$route->get("/users", "UserController@index");
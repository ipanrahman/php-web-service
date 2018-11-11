<?php

require_once __DIR__ . "/AutoLoader.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('PATH', str_replace("\\", "/", dirname(__FILE__)) . "/");

require PATH . "core/Bootstrap.php";
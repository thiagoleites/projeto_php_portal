<?php

require_once '../core/Autoloader.php';
require_once '../core/Router.php';

use Core\Router;

Router::dispatch();

use Core\Database\Connection;

$conn = Connection::getInstance();

var_dump($conn->getConnection());
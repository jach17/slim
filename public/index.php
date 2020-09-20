<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php'; 
require '../src/config/db.php';
$app = new Slim\App;

//Rutas del material
require '../src/rutas/modelo.php';
 


$app->run();
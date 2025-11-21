<?php
require_once 'app/controladores/HabitacionApiController.php';
require_once 'app/controladores/HotelApiController.php';
require_once 'app/controladores/TipoHabitacionApiController.php';
require_once 'libs/router/router.php';

$router = new Router();


$router->addRoute('habitaciones',     'GET',    'HabitacionApiController', 'getHabitaciones');
$router->addRoute('habitaciones/:id', 'GET',    'HabitacionApiController', 'getHabitacion');
$router->addRoute('habitaciones',     'POST',   'HabitacionApiController', 'insert');
$router->addRoute('habitaciones/:id', 'DELETE', 'HabitacionApiController', 'deleteHabitacion');
$router->addRoute('habitaciones/:id', 'PUT',    'HabitacionApiController', 'update');


$router->addRoute('hoteles',     'GET',    'HotelApiController', 'getHoteles');
$router->addRoute('hoteles/:id', 'GET',    'HotelApiController', 'getHotel');
$router->addRoute('hoteles',     'POST',   'HotelApiController', 'insert');
$router->addRoute('hoteles/:id', 'DELETE', 'HotelApiController', 'deleteHotel');
$router->addRoute('hoteles/:id', 'PUT',    'HotelApiController', 'update');


$router->addRoute('tipos',     'GET',    'TipoHabitacionApiController', 'getTipos');
$router->addRoute('tipos/:id', 'GET',    'TipoHabitacionApiController', 'getTipo');
$router->addRoute('tipos',     'POST',   'TipoHabitacionApiController', 'insert');
$router->addRoute('tipos/:id', 'DELETE', 'TipoHabitacionApiController', 'deleteTipo');
$router->addRoute('tipos/:id', 'PUT',    'TipoHabitacionApiController', 'update');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

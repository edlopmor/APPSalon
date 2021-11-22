<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

//Iniciar sesion 
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);

$router->get('/logout',[LoginController::class,'logout']);

//Contraseña perdida
$router->get('/lostPassword',[LoginController::class,'lostPassword']);
$router->post('/lostPassword',[LoginController::class,'lostPassword']);
//Redescribir la contraseña
 $router->get('/retrievePassword',[LoginController::class,'retrievePassword']);
 $router->post('/retrievePassword',[LoginController::class,'retrievePassword']);
//Crear cuenta
$router->get('/newAccount',[LoginController::class,'newAccount']);
$router->post('/newAccount',[LoginController::class,'newAccount']);

$router->get('/confirmarCuenta',[LoginController::class,'confirmarCuenta']);
$router->get('/mensaje',[LoginController::class,'mensaje']);

//Area privada 
$router->get('/cita',[CitaController::class,'index']);

$router->get('/admin',[AdminController::class,'index']);

//Api de citas 
$router->get('/api/servicios',[APIController::class,'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminar',[APIController::class, 'eliminar']);

//CRUD de servicios
$router ->get('/servicios',[ServicioController::class,'index']);

$router ->get('/servicios/crear',[ServicioController::class,'crear']);
$router ->post('/servicios/crear',[ServicioController::class,'crear']);

$router ->get('/servicios/actualizar',[ServicioController::class,'actualizar']);
$router ->post('/servicios/actualizar',[ServicioController::class,'actualizar']);

$router ->post('/servicios/eliminar',[ServicioController::class,'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
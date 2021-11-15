<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use MVC\Router;

$router = new Router();

//Iniciar sesion 
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);

// $router->post('/',[LoginController::class,'logout']);

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

//Api de citas 
$router->get('/api/servicios',[APIController::class,'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
<?php 

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        isAdmin();
        $servicios = Servicio::all();
        $router->render('servicios/index',[
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }
    public static function crear(Router $router){
        isAdmin();
        $servicio = new Servicio;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
                
            $servicio->sincronizar($_POST);
            
            $alertas = $servicio->validar();
            
            if(empty($alertas)){
                $servicio->crear();
                header("Location : /");
            }
        }
        $router->render('servicios/crear',[
            'nombre' => $_SESSION['nombre'],
            'servicio' =>$servicio,
            'alertas' => $alertas
        ]);
        
    }
    public static function actualizar(Router $router){
        isAdmin();
        $alertas = [];
        if(!is_numeric($_GET['id']))return;

        $id = $_GET['id'];
        
        $servicio = Servicio::get($id);
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();
            if (empty($alertas)){
                $servicio->actualizar($id);
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }
    public static function eliminar(){
        isAdmin();   
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            if(is_numeric($_POST['id'])){
                $id = $_POST['id'];
                $servicio = Servicio::find($id);
                
                $servicio->eliminar();

                header('Location: /servicios');
            }
            
        }
        
    }
}
<?php 
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router){
         
         isAdmin();
         
 
         $fechaHoy = date('Y-m-d');         
         $fecha = $_GET['fecha'] ?? $fechaHoy ;
         //Rompemos la cadena de la fecha para poder comprobarla y pasarsela al chekdate. 
         $arrayFecha = explode('-',$fecha);
         //Pasamos los varores de la fecha a chekdate para comprobar la validez, retorna un bool
         $fechaTest = checkdate($arrayFecha[1],$arrayFecha[2],$arrayFecha[0]);
        //Si no pasa el control lo envio a la pagina 404. ERROR
         if(!$fechaTest){
            header('Location: /404');       
        }
        //Consultar la base de datos 
         $query = " SELECT citas.id, citas.hora, concat(usuarios.nombre, ' ' , usuarios.apellido) as cliente, usuarios.email, usuarios.telefono,";
         $query .=" servicios.nombre AS servicio , servicios.precio ";
         $query .=" from citas LEFT JOIN USUARIOS ";
         $query .=" ON citas.usuarioId = usuarios.id ";
         $query .=" LEFT JOIN citasservicios ";
         $query .=" ON citasservicios.citaid= citas.id ";
         $query .=" LEFT JOIN servicios ";
         $query .=" on servicios.id = citasservicios.servicioid ";
         $query .= " WHERE fecha =  '${fecha}' ";

        $listaCitas = AdminCita::SQL($query);
        
        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'listaCitas' => $listaCitas,
            'fecha' => $fecha
        ]);
    }
}
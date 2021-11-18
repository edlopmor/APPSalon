<?php 
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router){

        //Consultar la base de datos 
         $query = " SELECT citas.id, citas.hora, concat(usuarios.nombre, ' ' , usuarios.apellido) as cliente, usuarios.email, usuarios.telefono,";
         $query .=" servicios.nombre AS servicio , servicios.precio ";
         $query .=" from citas LEFT JOIN USUARIOS ";
         $query .=" ON citas.usuarioId = usuarios.id ";
         $query .=" LEFT JOIN citasservicios ";
         $query .=" ON citasservicios.citaid= citas.id ";
         $query .=" LEFT JOIN servicios ";
         $query .=" on servicios.id = citasservicios.servicioid ";
        //  $query .= " WHERE fecha =  '${fecha}' ";

        $listaCitas = AdminCita::SQL($query);
        
        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'listaCitas' => $listaCitas
        ]);
    }
}
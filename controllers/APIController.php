<?php 
namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);

    }
    public static function guardar(){
        //Almacen la cita y develve el ID      
        $cita = new Cita($_POST);
        $resultado = $cita->crear();

        $id = $resultado['id'];
        //Almacena los servicios con el id de la cita
        $idServicios = explode(",", $_POST['servicios']);
        //Recorremos el array para insertar en la base de datos los datos de los servicios relacionados con esta cita 
        foreach ($idServicios as $idServicio){
            $args = [
                'citaid' => $id,
                'servicioid' =>$idServicio                
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->crear();
        }
        
        echo json_encode(['resultado'=>$resultado]);
    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            //Cargamos una instancia de la cita con el id que obtenemos de post. 
            $cita = Cita::find($id);
            //Procedemos a eliminar la cita. 
            $resultado = $cita->eliminar();
            if($resultado){
                header('Location:' . $_SERVER['HTTP_REFERER']); 
            }else {
                echo "No se ha podido eliminar la cita";
            }          
        }      
    }
}
?>
<?php
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $router->render('auth/login');
    }
    public static function logout(){
        echo "desde logout";
    }
    public static function lostPassword(Router $router){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
        }
        $router->render('auth/lostPassword',[
            
        ]);
    }
    // public static function retrievePassword(Router $router){
    //     if($_SERVER['REQUEST_METHOD']==='POST'){
            
    //     }
    //     $router->render('auth/lostPassword',[
            
    //     ]);
    // }
    public static function newAccount(Router $router){
        $usuario = new Usuario();
        //Array de errores
        $alertas = [];
        if($_SERVER['REQUEST_METHOD']==='POST'){           
          $usuario->sincronizar($_POST); 
          $alertas = $usuario->validarNuevaCuenta();

            //Revisamos que no haya alertas
            if(empty($alertas)){
            //Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    $usuario->hashPassword();
                    //Genera un toquen unico 
                    $usuario->crearToken();
                    //Creamos un nuevo mail, y lo enviamos 
                    // $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    // $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();
                        if($resultado){
                            header('location: /mensaje');
                        }

                } 
            }            
        }
        $router->render('auth/newAccount',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function confirmarCuenta(Router $router){
        $alertas = [];
        $token = sanear($_GET['token']);
        $usuario = Usuario::where('token',$token);

        if (empty($usuario)) {
            //Mostrar mensaje 
            Usuario::setAlerta('error','Token no válido');
        }else {            
            //Modificar el usuario para hacerlo confirmado
            $usuario->confirmado = 1;
            //Borrar su token unico para que no se pueda volver a utilizar
            $usuario->token = null;        
            $resultado = $usuario->guardar();
            //Si el resultado de la operacion guardar es verdadero , informamos al usuario. 
            if ($resultado){
                Usuario::setAlerta('exito','Cuenta activada con exito');
            }
        }
        //Obtener las alertas         
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/confirmarCuenta',[
            'alertas' => $alertas
        ]);       
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');


    }
}
   
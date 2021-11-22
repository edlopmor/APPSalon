<?php
namespace Controllers;

use Classes\Email;
use Classes\PasswordsEmail;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuario();
        //Si iniciabamos session con un administrador y despues con un cliente, se quedaba abierta la posibilidad de volver a entrar como administrador. 
        //Para evitarlo reiniciamos la session cada vez que haya un login. 
        $_SESSION = [];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
            $auth = new Usuario($_POST)?? null;
            //Obtenemos un usuario completo, solo necesitamos el campo mail y el campo password.
            $alertas= $auth->validarLogin();

            if(empty($alertas)){
                //Comprobar que exista el usuario 
                $usuario = Usuario::where('email',$auth->email);
                
                if($usuario){
                    
                    //Verificamos usuario confirmado y password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                                           
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre. " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        
                        if($usuario->admin === "1"){  
                            $_SESSION['admin'] = $usuario->admin;
                            header ('Location: /admin');
                        }else{
                            //Es cliente
                           header('Location: /cita');
                        }
                    
                    }                                      
                }else{
                    Usuario::setAlerta('error','Usuario no encontrado');
                }
            }
        }
        $alertas= Usuario::getAlertas();
        
        $router->render('auth/login',[
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }
    public static function logout(){
        $_SESSION = [];
        header('Location: /');

    }
    public static function lostPassword(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Usuario($_POST);
            $alertas =$auth->validarMail();
            if(empty($alertas)){
                $usuario = Usuario::where('email',$auth->email);
                if ($usuario && $usuario->confirmado === "1"){
                    //Generar un token de un solo uso 
                    $usuario->crearToken();
                    //Actualizar el usuario para añadirle token nuevo en la base de datos                    
                    $resultado = $usuario->actualizar($usuario->id);
                    //Comentado para no enviar emails en cada prueba
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarInstrucciones();
                        if($resultado){Usuario::setAlerta('exito','Enviado mensaje de recuperación');}
                }else{
                    Usuario::setAlerta('error','El usuario no existe o no ha sido confirmado.');
                }
            }
        }
        $alertas= Usuario::getAlertas();
        $router->render('auth/lostPassword',[
            'alertas' => $alertas
        ]);
    }
    public static function retrievePassword(Router $router){
        $alertas = [];
        $error = false;
        $token = sanear($_GET['token']);
        //Buscar el usuario por el token;
        $usuario = Usuario::where('token',$token);
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
            $error= true;
        }
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if (empty($alertas)){
                 $usuario->password = null;                
                 $usuario->password = $password->password;
                 $usuario->hashPassword();
                 $usuario->token= null;
                 $resultado =$usuario->actualizar($usuario->id);
                 if($resultado){
                     header('Location: /');
                 }
                 

            }
         }
        $alertas= Usuario::getAlertas();
        $router->render('auth/retrievePassword',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
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
                    
                    $resultado = $usuario->crear();
                    debuguear($resultado);
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
            $resultado = $usuario->actualizar($usuario->id);
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
   
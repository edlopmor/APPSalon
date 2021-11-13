<?php 
namespace Model;

class Usuario extends ActiveRecord {
    //Base de datos 
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token; 

    public function __construct($args = []){
        $this->id= $args['id']?? '';
        $this->nombre= $args['nombre'] ?? '';
        $this->apellido= $args['apellido'] ?? '';
        $this->email= $args['email'] ?? '';
        $this->password= $args['password'] ?? '';
        $this->telefono= $args['telefono'] ?? '';
        $this->admin= $args['admin'] ?? '0';
        $this->confirmado= $args['confirmado'] ?? '0';
        $this->token= $args['token'] ?? '';
        
    }
    //Mensajes de validacion para crear la cuenta. 

    public function validarNuevaCuenta()
    {
        if(!$this->nombre) {self::$alertas['error'] [] = 'Su nombre es obligatorio';}
        if(!$this->apellido) { self::$alertas['error'] [] = "Su apellido es obligatorio" ;}
        if(!$this->telefono) { self::$alertas['error'] [] = "Su numero de telefono es obligatorio" ;}
        if(!$this->email) { self::$alertas['error'] [] = "Su email es obligatorio" ;}
        if(!$this->password) { self::$alertas['error'] [] = "Debe introducir una contraseña" ;}
        if(strlen($this->password)< 6) {self::$alertas['error'] [] = "La contraseña debe contener al menos 6 caracteres" ;}   
        return self::$alertas;
    }
    //Validar login 
    public function validarLogin(){
        if(!$this->email) { self::$alertas['error'] [] = "Su email es obligatorio" ;}
        if(!$this->password) { self::$alertas['error'] [] = "Debe introducir una contraseña" ;}
        return self::$alertas;
    }
    public function validarMail(){
        if(!$this->email) { self::$alertas['error'] [] = "Su email es obligatorio" ;}
        return self::$alertas;
    }
    public function validarPassword(){
        if(!$this->password) { self::$alertas['error'] [] = "Debe introducir una contraseña" ;}
        if(strlen($this->password)< 6) {self::$alertas['error'] [] = "La contraseña debe contener al menos 6 caracteres" ;}
        return self::$alertas;
    }
        
    //Comprueba si el usuario existe en la base de datos. 
    public function existeUsuario(){
        $query = "SELECT * FROM ". self::$tabla ." WHERE email = '".$this->email ."' LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado->num_rows){
            self::$alertas['error'][] = 'Este email ya esta registrado';
        }
        return $resultado;
     }
     //Hashea la contraseña del usuario
     public function hashPassword(){
         $this->password = password_hash($this->password, PASSWORD_DEFAULT);
     }
     //Crea un token para el registro de usuarios. 
     public function crearToken(){
        $this->token = uniqid();
     }
     //Comprobar el password
     public function comprobarPasswordAndVerificado($password){
        //Comprobar el password
        $resultado = password_verify($password,$this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Password incorrecto o cuenta no verificada';
        }
            return true;
        }
     }
     
    

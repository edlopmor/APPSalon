<?php
namespace Controllers;

use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $router->render('auth/login');
    }
    public static function logout(){
        echo "desde logout";
    }
    public static function lostPassword(){
        echo "desde olvide Password";
    }
    public static function retrievePassword(Router $router){
        if($_SERVER['REQUEST_METHOD']==='POST'){

        }
        $router->render('auth/retrievePassword',[
            
        ]);
    }
    public static function newAccount(Router $router){

        if($_SERVER['REQUEST_METHOD']==='POST'){

        }
        $router->render('auth/newAccount',[

        ]);


    }
}   
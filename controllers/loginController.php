<?php
namespace Controllers;

class LoginController{
    public static function login(){
        echo "desde login";
    }
    public static function logout(){
        echo "desde logout";
    }
    public static function lostPassword(){
        echo "desde olvide Password";
    }
    public static function retrievePassword(){
        echo "desde reescribir password";
    }
    public static function newAccount(){
        echo "desde crearcuentas";
    }
}   
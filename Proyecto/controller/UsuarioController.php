<?php
require_once 'model/Usuario.php';
class UsuarioController{
    
    public $view;
    public $model;

    public function __construct()
    {
        $this -> model = new Usuario();
    }

    public function login(){
        $this -> view = "login";
    }

    public function logear(){

     // $usuario =  $this -> model->existeUsuario($_POST);



    }

    public function apiRegistrar()
    {
        $this -> view = "login";
        isset($_POST) ? $this -> model -> insertUsuario($_POST) : print_r("error");  
        
    }

}
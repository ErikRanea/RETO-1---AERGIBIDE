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

    public function logear()
    {
        if(!isset($_SESSION['is_logged_in'])||!$_SESSION['is_logged_in'])
        {
        
            
            $row = $this->model->login($_POST);
          
            if (isset($row)) 
            {
              
                //Si la base de datos dice que coincide la contraseña, creamos la sesion y entramos a temas
                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_data'] = array(
                "identificador" => $row -> id,
                "name" => $row->nombre,
                "email" => $row -> email,
                );

                return true;
            }   
            else 
            {
                $_SESSION['is_logged_in'] = false;
                
                return false ;
            }
        }
        return "error" ;
            
        
    }

    public function apiRegistrar()
    {
        $this -> view = "login";
        isset($_POST) ? $this -> model -> insertUsuario($_POST) : print_r("error");  
        
    }

}
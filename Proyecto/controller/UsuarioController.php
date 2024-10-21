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

}
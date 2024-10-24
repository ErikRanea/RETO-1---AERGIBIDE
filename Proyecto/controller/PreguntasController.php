<?php
require_once "model/Pregunta.php";

class PreguntasController{
    //public $page_title;
    public $view;
    public $model;

    public function __construct(){
        //$this->page_title = "";
        $this->view = "list";
        $this -> model = new Pregunta();
    }

    public function list(){
        $this->view = "list";

        $tema = $this->model->tema->getTemaById($_GET["id_tema"]);
        $preguntas = $this->model->getPreguntasPorTema($_GET["id_tema"]);
        foreach ($preguntas as &$pregunta) { //
            $usuario = $this->model->usuario->getUsuarioById($pregunta["id_usuario"]);
            $pregunta["usuario"] = $usuario;
        }
        unset($pregunta); 


        return [
            "preguntas" => $preguntas,
            "tema" => $tema
        ];

    }

    public function list_paginated(){
        $this->view = 'list_paginated';
        $page = isset($_GET["page"]) ? $_GET["page"]:1;
        $id_tema = $_GET["id_tema"];

        $tema = $this->model->tema->getTemaById($id_tema);
        $preguntas_pag = $this->model->getPreguntasPaginated($id_tema, $page);
        //SEPARAR preguntas_pag


        return [];
    }

    public function create(){
        $this->view = "create";
    }

    public function view()
    {
        $this ->view = "view";
    }





}
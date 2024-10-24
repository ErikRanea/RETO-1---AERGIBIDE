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

    /*
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
    */

    public function list(){
        $pagination = 5;
        $this->view = 'list';
        $page = isset($_GET["page"]) ? $_GET["page"]:1;
        $id_tema = $_GET["id_tema"];

        $tema = $this->model->tema->getTemaById($id_tema);
        $preguntas_pag = $this->model->getPreguntasPaginated($id_tema, $pagination, $page);

        //SEPARAR preguntas_pag
        $preguntas = $preguntas_pag[0];
        $paginas = [$preguntas_pag[1], $preguntas_pag[2]];

        foreach ($preguntas as &$pregunta) {
            $usuario = $this->model->usuario->getUsuariosById($pregunta["id_usuario"]);
            $pregunta["usuario"] = $usuario;
        }
        unset($pregunta);

        $this->dataToView["preguntas"] = $preguntas;
        $this->dataToView["tema"] = $tema;
        $this->dataToView["paginas"] = $paginas;

        return [
            "preguntas" => $preguntas,
            "tema" => $tema,
            "paginas" => $paginas
        ];
    }

    public function create(){
        $this->view = "create";
    }

    public function view()
    {
        $this ->view = "view";
    }





}
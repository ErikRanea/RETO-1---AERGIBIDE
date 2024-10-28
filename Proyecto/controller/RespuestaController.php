<?php
require_once "model/Respuesta.php";
class RespuestaController 
{
    public $view;
    public $model;

    public function __construct()
    {
        $this -> view = "view";
        $this -> model = new Respuesta();
    }

    public function view()
    {
        $this ->view = "view";

        $id = isset($_GET["id_pregunta"]) ? $_GET["id_pregunta"] : false;
        
        if(!$id)
        {
            header("Location: index.php?controller=tema&action=mostrarTemas");
        }



        $datosPreguntaRespuesta = $this ->model->getRespuestasConUsuariosByIdPregunta($id);
        

        

        return $datosPreguntaRespuesta;

    }
}
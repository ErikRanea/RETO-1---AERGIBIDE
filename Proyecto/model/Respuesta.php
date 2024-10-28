<?php
require_once "Pregunta.php";
require_once "Usuario.php";
class Respuesta
{
    private $tabla = "Respuestas";
    private $connection;
    public $usuario;
    public $pregunta;

    public function __construct()
    {
        $this -> getConnection();
        $this->usuario = new Usuario();
        $this->pregunta = new Pregunta();
    }

    public function getConnection(){
        $dbObj = new db();
        $this -> connection = $dbObj ->connection;
    }



    public function getRespuestasByIdPregunta($id)
    {
        $sql = "SELECT * FROM ".$this->tabla." WHERE id_pregunta = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt -> execute([$id]);
        return $stmt -> fetchAll();
    }



    public function getRespuestasConUsuariosByIdPregunta($id)
    {

        //Primero consigo las pregunta y el usuario que lo ha realizado


        $objetosPregunta = array();

        $pregunta = $this-> pregunta -> getPreguntaById($id);
        $usuarioPregunta = $this-> usuario -> getUsuarioById($pregunta["id_usuario"]);
        print_r($usuarioPregunta["nombre"]);
        die();

        $objetosPregunta["datosPregunta"] = $pregunta;
        $objetosPregunta["usuarioPregunta"] = $usuarioPregunta;

        //Luego consigo las respuestas con sus respectivo usuarios


        $respuestas = $this-> getRespuestasByIdPregunta($id);

        $usuariosRespuestas = array();

        foreach ($respuestas as $respuesta["id_usuario"] => $idUsuario) {
            $usuarioRespuesta=  $this -> usuario -> getUsuarioById($idUsuario);
            array_push($usuariosRespuestas,$usuarioRespuesta);
        }


        $objetosRespuestas["datosRespuestas"] = $respuestas;
        $objetosRespuestas["usuariosRespuestas"] = $usuariosRespuestas;
    


        $datosDePreguntaYRespuestas = array();
        $datosDePreguntaYRespuestas["pregunta"] =$objetosPregunta;
        $datosDePreguntaYRespuestas["respuestas"] = $objetosRespuestas;

        return $datosDePreguntaYRespuestas;

    }




}
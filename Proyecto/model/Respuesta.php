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


        $objetosPregunta["datosPregunta"] = $pregunta;
        $objetosPregunta["usuarioPregunta"] = $usuarioPregunta;



        //Luego consigo las respuestas con sus respectivo usuarios


        $respuestas = $this-> getRespuestasByIdPregunta($id);

        $usuariosRespuestas = array();

        for ($i=0; $i < count($respuestas) ; $i++) { 

            $usuarioRespuesta = $this->usuario -> getUsuarioById($respuestas[$i]["id_usuario"]);
            array_push($usuariosRespuestas, $usuarioRespuesta);
        }
  


        $objetosRespuestas["datosRespuestas"] = $respuestas;
        $objetosRespuestas["usuariosRespuestas"] = $usuariosRespuestas;
    

        // Almaceno tanto los datos de la preguntas y de las respuestas en un array de respuesta
        $datosDePreguntaYRespuestas = array();
        $datosDePreguntaYRespuestas["pregunta"] =$objetosPregunta;
        $datosDePreguntaYRespuestas["respuestas"] = $objetosRespuestas;


        //Recojo las preguntas y respuestas guardadas por el usuario de la sesion para verificar si ha guardado alguna
        $respuestasGuardadasUsuarioSesion = $this-> usuario-> getRespuestasSave($_SESSION["user_data"]["id"]);
        $preguntasGuardadasUsuarioSesion = $this -> usuario -> getPreguntasSave($_SESSION["user_data"]["id"]);

        //Almaceno los guardados en la respuesta
        $guardadosUsuarioSesion = array();
        $guardadosUsuarioSesion["preguntasGuardadas"] = $preguntasGuardadasUsuarioSesion;
        $guardadosUsuarioSesion["respuestasGuardadas"] = $respuestasGuardadasUsuarioSesion;

        $datosDePreguntaYRespuestas["guardados"] = $guardadosUsuarioSesion;



        //Recojo las preguntas y respuestas donde el usuario ha dado like para verificar si le ha gustado alguna
        $respuestasConLikesUsuarioSesion = $this -> usuario ->getRespuestasLike($_SESSION["user_data"]["id"]);
        $preguntasConLikesUsuarioSesion = $this -> usuario ->getPreguntasLike($_SESSION["user_data"]["id"]);

        $likesUsuarioSesion = array();
        $likesUsuarioSesion["preguntasLikes"] = $preguntasConLikesUsuarioSesion;
        $likesUsuarioSesion["respuestasLikes"] = $respuestasConLikesUsuarioSesion;

        $datosDePreguntaYRespuestas["likes"] = $likesUsuarioSesion;

        return $datosDePreguntaYRespuestas;

    }


    public function insertRespuesta($param)
    {
        try{
            $texto = $param["texto"];
            $imagen = $param["file_path"];
            $fecha_hora = date("Y-m-d H:i:s");
            $id_pregunta = $param["id_pregunta"];
            $id_usuario  = $_SESSION["user_data"]["id"];

            $sql = "INSERT INTO ".$this->tabla." (texto,imagen,fecha_hora,id_pregunta,id_usuario) VALUES (?,?,?,?,?)";
            $stmt = $this-> connection-> prepare($sql);
            $stmt->execute([$texto,$imagen,$fecha_hora,$id_pregunta,$id_usuario]);
            return true;
        }
        catch(error)
        {
            return false;
        }

    }

    public function guardarRespuesta($param)
    {
        try {
            $sql = "INSERT INTO Respuestas_Usu_Fav (id_usuario,id_respuesta) VALUES (?,?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$param["id_usuario"]],[$param["id_respuesta"]]);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function desGuardarRespuesta($param)
    {
        try {
            
            $sql = "DELETE FROM Respuestas_Usu_Fav WHERE id_usuario = ? AND id_respuesta = ?";
            $stmt = $this-> connection->prepare($sql);
            $stmt->execute([$param["id_usuario"]],[$param["id_respuesta"]]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


}
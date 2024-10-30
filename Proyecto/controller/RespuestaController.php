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

    public function create()
    {
        $post = $_POST["texto"] != "" && $_GET["id_pregunta"] != "" ? $_POST : false;
        if(!$post){header("Location: index.php?controler=tema&action=mostrarTemas");exit();}
        $filePath = null;
        print_r("Antes de entrar al if");
        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileMimeType = mime_content_type($fileTmpPath);
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];

            if(in_array($fileMimeType, $allowedMimeTypes)) {
                $fileName = uniqid(). $_FILES['imagen']['name'];
                print_r($fileName);
                $uploadFileDir = 'assets/upload/respuestas/';
                $destPath = $uploadFileDir.$fileName;

                // Movemos de temporal a /uploads
                if(move_uploaded_file($fileTmpPath,$destPath)){
                    $filePath = $destPath;
                }
                else {
                    $_GET["response"] = false;
                    print_r("No le ha permitido subir la imagen");
                    return;
                }
            } else {
                $_GET["response"] = false;
                return;
            }
        }



        $post["id_pregunta"] = $_GET["id_pregunta"];
        $post["file_path"]  = $filePath;


        $respuesta = $this->model->insertRespuesta($post);
        if($respuesta)
        {
            header("Location: index.php?controller=respuesta&action=view&id_pregunta=".$_GET["id_pregunta"]);
            exit();
        }
        else
        {
            print_r($respuesta);
            die();  
        }
        
     


    }



    public function guardarRespuesta()
    {
        try 
        {
            if(!isset($_POST["id_usuario"]) && !isset($_POST["id_respuesta"]))
            {
                throw new Exception("No se han entregado los id usuario y respuesta");
            }    

            $guardarRespuesta = $this->model->guardarRespuesta($_POST);
            if(!$guardarRespuesta)
            {
                throw new Exception("Ha habido un error en la base de datos al guardar la respuesta");
            }
            elseif($guardarRespuesta)
            {
                echo json_encode([
                    "status" => "success",
                    "message" => "Se ha guardado la respuesta correctamente"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => $e,
            ]);
            exit();
        }
    }



}
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
}
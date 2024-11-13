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
        if(!$post){sleep(3);header("Location: index.php?controller=respuesta&action=view&id_pregunta=".$_GET["id_pregunta"]);exit();}
        $filePath = null;


        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileMimeType = mime_content_type($fileTmpPath);
            
            // Tipos de archivo permitidos
            $allowedImageMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
            $allowedPdfMimeType = 'application/pdf';
    
            // Aquí procesamos la imagen
            if(in_array($fileMimeType, $allowedImageMimeTypes)) {
                $fileName = uniqid() . $_FILES['imagen']['name'];
                $uploadFileDir = 'assets/upload/respuestas/';
                $destPath = $uploadFileDir . $fileName;
    
                // Mover archivo de imagen
                if(move_uploaded_file($fileTmpPath, $destPath)) {
                    $filePath = $destPath;
                } else {
                    $_GET["response"] = false;
                    print_r("No se pudo subir la imagen");
                    return;
                }
            }
            // Y aqui procesamos el pdf
            elseif($fileMimeType === $allowedPdfMimeType) {
                $fileName = uniqid() . $_FILES['imagen']['name'];
                $uploadFileDir = 'assets/upload/respuestas/';
                $destPath = $uploadFileDir . $fileName;
    
                // Mover archivo PDF
                if(move_uploaded_file($fileTmpPath, $destPath)) {
                    $filePath = $destPath;
                } else {
                    $_GET["response"] = false;
                    print_r("No se pudo subir el archivo PDF");
                    return;
                }
            } else {
                // Tipo de archivo no permitido
                $_GET["response"] = false;
                print_r("Tipo de archivo no permitido");
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


    public function remove()
    {

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
 
            try 
            {

                
                $idUsuario = $_SESSION['user_data']['id'];
                $_POST["id_usuario"] = $idUsuario;


                $datos = $this->model->getRespuestaYUsuario($_POST);
        
                

                if(!$this->puedeEditar($datos["respuesta"]["id_usuario"]))
                {
                    echo json_encode([
                        "status" => "error",
                        "message" => "No tiene permiso para eliminar este elemento"
                    ]);
                    exit();
                }
    
                /*Esta variable de sesión será utilizada para que sin un previo acceso a está ventana, no te permita realizar un borrado */
                $_SESSION['user_data']['autorizado'] = true;
    
              
                echo json_encode([
                    "status" => "success",
                    "data" => $datos
                ]);
                exit();    
            } 
            catch (Error $e)
            {   
                echo json_encode([
                "status" => "error",
                "message" => "Ha sucedido el siguiente error: ".$e
                ]);
                exit();
            }
 
        }
        else
        {
            header("Location: index.php");
            exit();
        }



    }

    public function delete()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {


            try {
            
                if(!isset($_POST["id_respuesta"]) || !isset($_POST["id_pregunta"]) || !isset($_SESSION['user_data']['autorizado']))
                {
                    echo json_encode([
                        "status" => "error",
                        "message" => "No está autorizado para realizar dicha operación",
                        "redirect" => "index.php?"
                    ]);
                    exit();
                }
                elseif($_SESSION['user_data']['autorizado'])
                {

                    $respuesta = $this-> model -> getRespuestaById($_POST["id_respuesta"]);

                    if($respuesta["imagen"] != "")
                    {
                        $imagenEliminada = $this -> eliminarImagen($respuesta["imagen"]);
                        if(!$imagenEliminada)
                        {
                            throw new Error("No se ha borrado la imagen correctamente");
                        }
                    }

                    $result = $this-> model -> deleteRespuestaById($_POST["id_respuesta"]);
                    if($result)
                    {
                        unset($_SESSION['user_data']['autorizado']);
                        echo json_encode([
                            "status" => "success",
                            "redirect" => "index.php?controller=respuesta&action=view&id_pregunta=".$_POST["id_pregunta"]
                        ]);
                        exit();
                    }
                }

            } catch (Error $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Ha sucedido el siguiente error en el servidor: ".$e
                ]);
                exit();
            }

        }
        else
        {
            header("Location: index.php");
            exit();
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


    /* Like a pregunta de manera asincrona */
    public function like()
    {

        $idRespuesta = $_POST["idRespuesta"];
        $idUsuario = $_POST["idUsuario"];
        $meGusta = $_POST["meGusta"];

        //Primero, comprobamos si el usuario ya ha votado la pregunta
        $like = $this->model->getLikeRespuesta(["idRespuesta" => $idRespuesta, "idUsuario" => $idUsuario]);

        if($like)
        {
            //Si ya ha votado, updateamos el voto

            $result = $this->model->updateLikeRespuesta(["idRespuesta" => $idRespuesta, "idUsuario" => $idUsuario, "meGusta" => $meGusta]);

            if($result)
            {
                echo json_encode(["status" => "success","message" => "Votado actualizado correctamente la respuesta"]);
                exit;
            }
            else
            {
                $result = $this->model->deleteLikeRespuesta(["idRespuesta" => $idRespuesta, "idUsuario" => $idUsuario]);
                if($result)
                {
                    echo json_encode(["status" => "success","message" => "Voto eliminado correctamente la respuesta"]);
                    exit;
                }
                else
                {
                    echo json_encode(["status" => "error","message" => "Error al borrar el voto de la respuesta"]);
                    exit;
                }
            }
        }
        else
        {
            //Si no ha votado, insertamos el voto
            $result = $this->model->insertLikeRespuesta(["idRespuesta" => $idRespuesta, "idUsuario" => $idUsuario, "meGusta" => $meGusta]);

            if($result)
            {
                echo json_encode(["status" => "success","message" => "Votado correctamente la respuesta"]);
                exit;
            }
            else
            {
                echo json_encode(["status" => "error","message" => "Error al votar la respuesta"]);
                exit;
            }
        }

    }


    public function guardados()
    {
        try
        {
            $param = $_POST;

            $idRespuesta = $param["idRespuesta"];




            $estaGuardado = false;



            $listaGuardados = $this->model->usuario->getRespuestasSave($param["idUsuario"]);



            foreach ($listaGuardados as $guardado) {
                if($guardado["id_respuesta"] == $idRespuesta)
                {
                    $estaGuardado = true;
                }
            }




            if($estaGuardado)
            {


                $result = $this -> model -> deleteGuardarRespuesta($param);
                if($result)
                {
                    echo json_encode(["status" => "success","message" => "delete OK"]);
                    exit;
                }
                else
                {
                    //No se le añade mensaje para que muestre el error de la base de datos
                    throw new Error();
                }


            }
            else
            {
                $result =  $this -> model -> saveGuardarRespuesta($param);
                if($result)
                {
                    echo json_encode(["status" => "success","message" => "add OK"]);
                    exit;
                }
                else
                {
                    throw new Error();
                }

            }
        }
        catch (Error $e)
        {
           echo json_encode(["status" => "error","message" => "Ha sucedido el siguiente error -> ".$e]);
           exit();

        }
    }

    public function edit()
    {
        try 
        {

            if($_SERVER["REQUEST_METHOD"] == "GET")
            {
                header("Location: index.php?controller=tema&action=mostrarTemas");
                exit();
            }
            if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["idRespuesta"]))
            {
                throw new Exception("No se han recibido los datos necesarios para editar la respuesta");
            }


            // Manejar la imagen si se subió una nueva
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['imagen']['tmp_name'];
                $fileMimeType = mime_content_type($fileTmpPath);
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];

                if(in_array($fileMimeType, $allowedMimeTypes)) {
                    $fileName = uniqid() . $_FILES['imagen']['name'];
                    $uploadFileDir = 'assets/upload/respuestas/';
                    $destPath = $uploadFileDir . $fileName;

                    if(move_uploaded_file($fileTmpPath, $destPath)) {
                        $_POST['imagen'] = $destPath;
                    } else {
                        throw new Exception("Error al subir la imagen");
                    }
                } else {
                    throw new Exception("Tipo de archivo no permitido");
                }
            }

            $result = $this->model->updateRespuesta($_POST);
            if($result) {
                header("Location: index.php?controller=respuesta&action=view&id_pregunta=".$_POST["id_pregunta"]);
                exit();
            } else {
                throw new Exception("Error al actualizar la respuesta en la base de datos");
            }

        }
        catch (Exception $e)
        {
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
        exit();
    }

    public function verRespuesta()
    {
        $id_pregunta = $_GET['id_pregunta'] ?? null;
        $id_notificacion = $_GET['id_notificacion'] ?? null;

        if (!$id_pregunta) {
            // Si no hay id_pregunta, redirigimos a la página de temas
            header("Location: index.php?controller=tema&action=mostrarTemas");
            exit();
        }

        // Marcamos la notificación como leída si existe
        if ($id_notificacion) {
            $this->marcarNotificacionComoLeida($id_notificacion);
        }

        // Obtenemos los datos de la pregunta y las respuestas
        $datosPregunta = $this->model->pregunta->getPreguntaById($id_pregunta);
        $datosRespuestas = $this->model->getRespuestasConUsuariosByIdPregunta($id_pregunta);

        // Preparamos el array de datos para la vista
        $dataToView = [
            'pregunta' => $datosPregunta,
            'respuestas' => $datosRespuestas
        ];

        // Configuramos la vista a mostrar
        $this->view = "view";

        // Retornamos los datos para que se usen en la vista
        return $dataToView;
    }

    public function deleteGuardado() {
        $idRespuesta = $_POST['idRespuesta'];
        $idUsuario = $_POST['idUsuario'];

        $respuestaModel = new Respuesta();
        $result = $respuestaModel->deleteGuardarRespuesta([
            "idRespuesta" => $idRespuesta,
            "idUsuario" => $idUsuario
        ]);

        if ($result) {
            // Obtener el ID de la pregunta asociada a la respuesta
            $idPregunta = $respuestaModel->getIdPreguntaByRespuesta($idRespuesta);

            echo json_encode([
                'status' => 'success',
                'message' => 'Respuesta eliminada de guardados',
                'redirect' => "index.php?controller=respuesta&action=view&id_pregunta=" . $idPregunta
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo eliminar la respuesta de guardados'
            ]);
        }
        exit;
    }

    public function esUtil()
    {
        try
        {
            $idRespuesta = $_GET["idRespuesta"];
            $idPregunta = $_GET["idPregunta"];
            $id = array();
            $id["idPregunta"] = $idPregunta;
            $id["idRespuesta"] = $idRespuesta;
            $result = $this->model->setFav($id);    

            if($result)
            {
                header("Location: index.php?controller=respuesta&action=view&id_pregunta=".$idPregunta);
            }
            else
            {
                throw new Error("Error al marcar la respuesta como util");
            }

        }
        catch (Error $e)
        {
            echo "Ha sucedido el siguiente error -> ".$e;
            exit();
        }
    }

    public function cuentaDeVotos()
    {

        try
        {
            if(!isset($_POST["id"]) || !isset($_POST["tipo"]))
            {
                throw new Error("No permitido");
            }
            if($_SERVER["REQUEST_METHOD"] == "GET")
            {
                header("Location: index.php");
            }

            $result = $this->model->contarVotos($_POST,$_POST);

            if($result)
            {
                echo json_encode([
                    "status" => "success",
                    "votos" => $result
                ]);
                exit;
            }
            else
            {
                echo json_encode([
                    "status" => "error",
                    "message" => "No se han devuelto los votos"
                ]);
            }



        }
        catch (Error $e) {
            echo json_encode([
                "status" => "error",
                "message" => "Se ha creado el siguiente error: ".$e
            ]);
            exit;
        }


    }
















////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*Funciones para uso exclusivo del controlador */

private function puedeEditar($id)
{
    $puedeEditar = false;
    $idUsuario = $_SESSION["user_data"]["id"];
    $rol = $_SESSION["user_data"]["rol"];

    if($idUsuario == $id)
    {
         return $puedeEditar = true;
    }
    elseif (($rol == "admin") || ($rol == "gestor")) {
        return $puedeEditar = true;
    }

    return $puedeEditar;
}

private function esDueno($id)
{
    $puedeEditar = false;
    $idUsuario = $_SESSION["user_data"]["id"];

    if($idUsuario == $id)
    {
         return $puedeEditar = true;
    }
    return $puedeEditar;
}

    private function eliminarImagen($path)
    {

        if (file_exists($path)) {
            
            if (unlink($path)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }



}
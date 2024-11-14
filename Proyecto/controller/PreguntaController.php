<?php
require_once "model/Pregunta.php";

class PreguntaController{
    //public $page_title;
    public $view;
    public $model;

    public function __construct(){
        //$this->page_title = "";
        $this->view = "list";
        $this -> model = new Pregunta();
    }

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
            $usuario = $this->model->usuario->getUsuarioById($pregunta["id_usuario"]);
            $pregunta["usuario"] = $usuario;
            $tipo = array();
            $tipo["tipo"] = "pregunta";
            $pregunta["cuentaVotos"] = $this->model->contarVotos(["tipo"=>$tipo["tipo"],"id"=>$pregunta["id"]]);
        }
        unset($pregunta);


        return [
            "pregunta" => $preguntas,
            "tema" => $tema,
            "paginas" => $paginas
        ];
    }

    public function create(){
        $this->view = "create";

        $temas = $this->model->tema->getTemas();

        return[
            "temas" => $temas
        ];
    }


    public function save(){
        $this->view = 'mensaje';

    
        $filePath = null;



    

        if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileMimeType = mime_content_type($fileTmpPath);
            

            $allowedImageMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
            $allowedPdfMimeType = 'application/pdf';

       
            if(in_array($fileMimeType, $allowedImageMimeTypes)) {
                $fileName = uniqid() . $_FILES['imagen']['name'];
                $uploadFileDir = 'assets/upload/preguntas/';
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
         
            elseif($fileMimeType === $allowedPdfMimeType) {
                $fileName = uniqid() . $_FILES['imagen']['name'];
                $uploadFileDir = 'assets/upload/preguntas/';
                $destPath = $uploadFileDir . $fileName;


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


        // Ahora pasamos todos los datos (incluido el archivo, si existe) al modelo
        $param = $_POST;
        $param['file_path'] = $filePath;

        $id = $this->model->save($param);

        $result = $this->model->getPreguntaById($id);

        $_GET["response"] = true;
        return ["pregunta" => $result];

        
    }



    public function view()
    {
        $this ->view = "view";

        $id = isset($_GET["id_pregunta"]) ? $_GET["id_pregunta"] : false;
        
        if(!$id)
        {
            header("Location: index.php?controller=tema&action=mostrarTemas");
        }



        $pregunta = $this ->model->getPreguntaById($id);
        $usuarioPregunta = $this -> model -> usuario -> getUsuarioById($pregunta["id_usuario"]);

        $datos = array();

        

        $datos["pregunta"] = $pregunta;
        $datos["usuario"] = $usuarioPregunta;
  

        return $datos;

    }


    /* Like a pregunta de manera asincrona */
    public function like()
    {

        $idPregunta = $_POST["idPregunta"];
        $idUsuario = $_POST["idUsuario"];
        $meGusta = $_POST["meGusta"];

        //Primero, comprobamos si el usuario ya ha votado la pregunta
        $like = $this->model->getLikePregunta(["idPregunta" => $idPregunta, "idUsuario" => $idUsuario]);

        if($like)
        {
            //Si ya ha votado, updateamos el voto
            
            $result = $this->model->updateLikePregunta(["idPregunta" => $idPregunta, "idUsuario" => $idUsuario, "meGusta" => $meGusta]);

            if($result)
            {
                echo json_encode(["status" => "success","message" => "Votado actualizado correctamente la pregunta  "]);
                exit;
            }
            else
            {
                $result = $this->model->deleteLikePregunta(["idPregunta" => $idPregunta, "idUsuario" => $idUsuario]);
                if($result) 
                {
                    echo json_encode(["status" => "success","message" => "Voto eliminado correctamente la pregunta"]);
                    exit;
                }
                else
                {
                    echo json_encode(["status" => "error","message" => "Error al borrar el voto de la pregunta"]);
                    exit;
                }
            }
        }
        else
        {
            //Si no ha votado, insertamos el voto
            $result = $this->model->insertLikePregunta(["idPregunta" => $idPregunta, "idUsuario" => $idUsuario, "meGusta" => $meGusta]);

            if($result)
            {
                echo json_encode(["status" => "success","message" => "Votado correctamente la pregunta"]);
                exit;
            }
            else
            {
                echo json_encode(["status" => "error","message" => "Error al votar la pregunta"]);
                exit;
            }
        }

    }   

    public function guardados(){
        
        try 
        {
            $param = $_POST;

            $idPregunta = $param["idPregunta"];


            $estaGuardado = false;



            $listaGuardados = $this->model->usuario->getPreguntasSave($param["idUsuario"]);


            foreach ($listaGuardados as $guardado) {
                if($guardado["id_pregunta"] == $idPregunta)
                {
                
                    $estaGuardado = true;
                }            
            }
            
            if($estaGuardado)
            {
                
                $result = $this -> model -> deleteGuardarPregunta($param);
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
                $result =  $this -> model -> saveGuardarPregunta($param);
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

        if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_pregunta"]))
        {

            $pregunta = $this-> model -> getPreguntaById($_GET["id_pregunta"]);

            if(!$this->esDueno($pregunta["id_usuario"]))
            {
                header("Location: index.php?controller=tema&action=mostrarTemas");
                exit();
            }
            else
            {
                $this-> view = "edit";
                return $pregunta;
            }



        }


    }

    public function update()
    {

        try 
        {
            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST))
            {

                   // Primero, verificamos si se ha subido un archivo
                    $filePath = null;
                    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){


                        $fileTmpPath = $_FILES['imagen']['tmp_name'];
                        $fileMimeType = mime_content_type($fileTmpPath);
                        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];

                        if(in_array($fileMimeType, $allowedMimeTypes)) {
                            $fileName = uniqid(). $_FILES['imagen']['name'];
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


                $_POST["file_path"] = $filePath;
                $result = $this->model->updatePregunta($_POST);
                if($result)
                {
                    header("Location: index.php?controller=respuesta&action=view&id_pregunta=".$_POST["id_pregunta"]);
                }
                else
                {   
                    throw new Error("No se ha realizado la update en la base de datos");
                }
            }   
            else
            {
                throw new Error();
            }

        } catch (Error $e) {
            header("Location: index.php");
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

                $datos = $this->model->getPreguntaYUsuario($_POST);



                if(!$this->puedeEditar($datos["pregunta"]["id_usuario"]))
                {
                    echo json_encode([
                        "status" => "error",
                        "message" => "El usuario no está autorizado para realizar dicha acción",
                        "redirect" => "index.php?controller=tema&mostrarTemas"
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
                
                if( !isset($_POST["id_pregunta"]) || !isset($_SESSION['user_data']['autorizado']))
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

                    
    
                    $idTema = $this -> model -> getIdTemaByIdPregunta($_POST["id_pregunta"]);
                    
                    $pregunta = $this-> model -> getPreguntaById($_POST["id_pregunta"]);

                    if($pregunta["imagen"] != "")
                    {
                        $imagenEliminada = $this -> eliminarImagen($pregunta["imagen"]);
                        if(!$imagenEliminada)
                        {
                            throw new Error("No se ha borrado la imagen correctamente");
                        }
                    }


                    $result = $this-> model -> deletePreguntaById($_POST["id_pregunta"]);
                    if($result)
                    {


                        unset($_SESSION['user_data']['autorizado']);
                        echo json_encode([
                            "status" => "success",
                            "redirect" => "index.php?controller=pregunta&action=list&id_tema=".$idTema["id_tema"]
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
    }
   






























    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*Metodos exclusivos para el uso interno del controlador */

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



}


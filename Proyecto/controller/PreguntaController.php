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
            $usuario = $this->model->usuario->getUsuariosById($pregunta["id_usuario"]);
            $pregunta["usuario"] = $usuario;
        }
        unset($pregunta);

        $this->dataToView["pregunta"] = $preguntas;
        $this->dataToView["tema"] = $tema;
        $this->dataToView["paginas"] = $paginas;

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

    /* Create the note */
    public function save(){
        $this->view = 'create';

        // Primero, verificamos si se ha subido un archivo
        $filePath = null;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            // Si el archivo es válido, procesarlo
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $fileName = uniqid()."_".$fileName;
            $uploadFileDir = './assets/uploads/preguntas/';
            $destPath = $uploadFileDir . $fileName;

            // Verificar que el directorio de subida exista, sino crear uno
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            // Mover el archivo desde su ubicación temporal al directorio final
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Si el archivo se movió correctamente, guardar la ruta de archivo
                $filePath = $destPath;
            } else {
                // Si hubo un error al mover el archivo
                $_GET["response"] = false;
                return;
            }
        }

        // Ahora pasamos todos los datos (incluido el archivo, si existe) al modelo
        $param = $_POST;
        $param['file_path'] = $filePath;

        $id = $this->model->save($param);
        $result = $this->model->getPreguntaById($id);
        $_GET["response"] = true;
        return $result;
    }





}
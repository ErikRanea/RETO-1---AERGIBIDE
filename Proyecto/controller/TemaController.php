<?php
require_once 'model/Tema.php';
require_once 'model/Publicacion.php';

class TemaController {
    public $view;
    public $model;

    public function __construct() {
        $this->model = new Tema();  // Instancia del modelo Tema
    }

    // Método para mostrar los temas y preguntas
    public function mostrarTemas() {
        $temas = $this->model->getTemas();  // Obtiene los temas
        $publicacionModel = new publicacion();

        // Vamos a obtener todas las preguntas
        $publicaciones = $publicacionModel->getPubliaciones();  // Obtiene todas las preguntas

        // Asigna los temas y preguntas a $dataToView
        $dataToView["temas"] = $temas;
        $dataToView["publicaciones"] = $publicaciones;


        $this->view = 'view';  // Asigna la vista
        return $dataToView;  // Devuelve los datos a la vista
    }

    // Método para ver los detalles de un tema específico junto a sus preguntas
    public function view() {
        $tema_id = $_GET['id'];  // Obtiene el ID del tema
        $tema = $this->model->getTemaById($tema_id);  // Obtiene el tema por ID

        // Obtener las preguntas asociadas a este tema
        $preguntaModel = new Pregunta();
        $preguntas = $preguntaModel->getPreguntasByTemaId($tema_id);

        // Pasar los datos de tema y preguntas a la vista
        $dataToView["data"] = $tema;
        $dataToView["preguntas"] = $preguntas;

        $this->view = 'view';  // Asigna la vista
        return $dataToView;  // Devuelve los datos
    }
}

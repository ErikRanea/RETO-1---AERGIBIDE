<?php
require_once 'model/Publicacion.php';

class BusquedaController {
    public $view;
    public $model;

    public function __construct() {
        $this->model = new Publicacion();  // Instancia del modelo Publicacion
    }

    public function buscar() {
        // Obtener el término de búsqueda desde la solicitud GET
        $termino = isset($_GET['termino']) ? $_GET['termino'] : '';

        // Realizar la búsqueda en preguntas y respuestas
        $resultados = $this->model->buscarPublicaciones($termino);

        // Asignar los resultados a $dataToView
        $dataToView["resultados"] = $resultados;
        $dataToView["termino"] = $termino;

        $this->view = '/view';  // Asigna la vista para mostrar los resultados
        return $dataToView;  // Devuelve los datos a la vista
    }
}

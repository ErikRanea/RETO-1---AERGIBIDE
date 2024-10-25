<?php
require_once 'model/Publicacion.php';

class BusquedaController {
    public $view;
    public $model;

    public function __construct() {
        $this->model = new Publicacion();  // Instancia del modelo Publicacion
    }

    public function buscar() {
        // Obtener el término de búsqueda y el filtro desde la solicitud GET
        $termino = isset($_GET['termino']) ? $_GET['termino'] : '';
        $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todo';
        $orden = isset($_GET['orden']) ? $_GET['orden'] : 'reciente'; // Obtener el orden

        // Realizar la búsqueda en preguntas y respuestas
        if ($filtro === 'titulo') {
            $resultados = $this->model->buscarPublicacionesPorTitulo($termino, $orden);
        } else {
            $resultados = $this->model->buscarPublicaciones($termino, $filtro, $orden);
        }

        // Asignar los resultados a $dataToView
        $dataToView["resultados"] = $resultados;
        $dataToView["termino"] = $termino;

        $this->view = '/view';  // Asigna la vista para mostrar los resultados
        return $dataToView;  // Devuelve los datos a la vista
    }


}

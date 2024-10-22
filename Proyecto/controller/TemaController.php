<?php
require_once 'model/Tema.php';

class TemaController {
    public $view;
    public $model;

    public function __construct() {
        $this->model = new Tema();
    }

    // Método para cargar la vista con los temas
    public function mostrarTemas() {
        $temas = $this->model->getTemas();
        require_once 'view/tema/view.html.php';
    }
}

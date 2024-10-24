<?php
require_once 'model/Publicacion.php';

class PublicacionController {
    public $view = 'view';  // Nombre de la vista que se va a cargar

    public function mostrarPublicaciones() {
        // Instanciamos el modelo de preguntas
        $modelPublicacion = new Publicacion ();
        $Publicaciones = $modelPublicacion ->getPublicaciones();  // Llamamos al método para obtener las preguntas y respuestas

        // Si ocurre algún error lo capturamos en la variable y lo pasamos a la vista
        if (isset($Publicaciones['error'])) {
            return ['error' => $Publicaciones['error']];
        }

        // Pasamos las preguntas al array dataToView
        return ['Publicaciones' => $Publicaciones];
    }
}

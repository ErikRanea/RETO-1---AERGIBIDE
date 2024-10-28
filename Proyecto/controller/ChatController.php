<?php
require_once 'model/Usuario.php';
class ChatController
{
    public $model;
    public $view = "view";

    public function __construct()
    {
        $this->model = new Usuario(); // Modelo Usuario
    }

    public function obtenerUsuarios()
    {
        // Obtener todos los usuarios
        $usuarios = $this->model->ObtenerUsuarios();

        // Asignar los usuarios a $dataToView
        $dataToView["usuarios"] = $usuarios;

        // Retornar los datos a la vista
        return $dataToView;
    }


public function mostrarChat() {
    $usuarioModel = new Usuario();
    $usuarios = $usuarioModel->ObtenerUsuarios();

    // Preparar los datos para la vista
    $dataToView = [];
    $dataToView['usuarios'] = $usuarios;

    // Retornar los datos para que el index.php los reciba
    return $dataToView;
}

    public function enviarMensaje() {
        // Obtener datos de la solicitud AJAX
        $input = json_decode(file_get_contents('php://input'), true);
        $mensaje = $input['mensaje'] ?? '';
        $receptorId = $input['receptorId'] ?? '';

        if (!empty($mensaje) && !empty($receptorId)) {
            $chatModel = new Chat();
            $emisorId = $_SESSION['user_id']; // Obtener el ID del usuario logueado

            $success = $chatModel->guardarMensaje($emisorId, $receptorId, $mensaje);

            // Responder con JSON
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
        }
        exit();
    }


}

<?php
require_once 'model/Chat.php';
require_once 'model/Usuario.php';
require_once 'model/Db.php'; // Asegúrate de incluir la clase Db

class ChatController
{
    private $usuarioModel;
    private $chatModel;
    public $view = "view";

    public function __construct()
    {
        $this->usuarioModel = new Usuario(); // Modelo Usuario
        $db = new Db(); // Crear instancia de Db
        $this->chatModel = new Chat($db->connection);
        // Pasar la conexión al modelo Chat
    }

    public function mostrarChat() {
        // Verificar que la sesión tenga el id_usuario
        if (!isset($_SESSION['user_id'])) {
            return ['error' => 'Usuario no autenticado'];
        }

        // Obtener la lista de usuarios
        $usuarios = $this->usuarioModel->obtenerUsuarios();

        // Preparar los datos para la vista
        $dataToView = [
            'usuarios' => $usuarios,
            // Si necesitas mensajes iniciales, puedes incluirlo aquí
            // 'mensajes' => $this->chatModel->obtenerMensajesIniciales($_SESSION['user_id'])
        ];

        // Retornar los datos para que el index.php los reciba
        return $dataToView;
    }

    public function enviarMensaje() {
        // Obtener datos de la solicitud AJAX
        $input = json_decode(file_get_contents('php://input'), true);
        $mensaje = $input['mensaje'] ?? '';
        $receptorId = $input['receptorId'] ?? '';

        if (!empty($mensaje) && !empty($receptorId)) {
            $emisorId = $_SESSION['user_id']; // Obtener el ID del usuario logueado
            $success = $this->chatModel->guardarMensaje($emisorId, $receptorId, $mensaje);

            // Responder con JSON
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
        }
        exit();
    }

    public function obtenerMensajesPorUsuario($id_emisor, $id_receptor) {
        return $this->chatModel->getMessages($id_emisor, $id_receptor);
    }

    public function get_messages() {
        $id_emisor = $_GET['id_emisor'] ?? null;
        $id_receptor = $_GET['id_receptor'] ?? null;

        if ($id_emisor === null || $id_receptor === null) {
            echo json_encode(['error' => 'ID de emisor o receptor no proporcionado.']);
            exit(); // Agrega un exit() para detener la ejecución del script
        }

        $mensajes = $this->chatModel->obtenerMensajes($id_emisor, $id_receptor);

        // Verificar si hay mensajes
        if (empty($mensajes)) {
            echo json_encode(['mensaje' => 'No hay mensajes aún.']);
        } else {
            echo json_encode($mensajes);
        }
        exit(); // Agrega un exit() para detener la ejecución del script
    }

    public function getIdEmisorMensaje($idMensaje) {
        $idEmisor = $this->chatModel->getIdEmisorByIdMensaje($idMensaje);
        return $idEmisor;
    }

    // controller/ChatController.php
    // controller/ChatController.php
    public function fetchMessages() {
        $id_emisor = $_GET['id_emisor'];
        $id_receptor = $_GET['id_receptor'];

        // Aquí debes obtener los mensajes desde la base de datos
        $mensajes = $this->chatModel->getMessages($id_emisor, $id_receptor); // Ajusta esto según tu lógica

        header('Content-Type: application/json');
        echo json_encode($mensajes); // Asegúrate de que esto sea un JSON válido
    }


}

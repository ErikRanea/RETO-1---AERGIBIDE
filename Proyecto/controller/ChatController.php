<?php
require_once 'model/Chat.php';
require_once 'model/Usuario.php';
require_once 'model/Db.php';

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
        if (!isset($_SESSION['user_data']['id'])) {
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





}

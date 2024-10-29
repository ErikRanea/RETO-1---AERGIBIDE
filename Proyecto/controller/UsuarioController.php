<?php
require_once 'model/Usuario.php';
class UsuarioController{

    public $view;
    public $model;

    public function __construct()
    {
        $this -> model = new Usuario();
    }

    public function login(){
        $this -> view = "login";
    }

    public function datosUsuario(){
        $usuarioId = $_SESSION['user_data']['id'];
        // Obtenemos los datos del usuario desde el modelo
        $usuario = $this->model->getUsuarioById($usuarioId);
        // Verificamos si el usuario está correctamente cargado
        if ($usuario) {
            echo json_encode($usuario); // Enviamos la respuesta JSON
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
        exit; // Nos aseguramos de que PHP no siga procesando después de enviar la respuesta
    }

    public function datosUsuarioBlack(){
        $this -> view = "datosUsuarioBlack";
    }

    /*
    Metodo -> logear
    From -> Erik
    Descripción -> Esta función está pensada para que se utilice tras un Fetch desde Javascript,
    por lo tanto las respuestas que devuelve son para ser tratadas en assets/js/login.js */


    public function logear()
    {
        header('Content-Type: application/json');  // Establecer el tipo de contenido como JSON

        if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in'])
        {
            $row = $this->model->login($_POST);

            if (isset($row))
            {
                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_data'] = array(
                    "id" => $row->id,
                    "nombre" => $row->nombre,
                    "email" => $row->email,
                    "username" => $row->username
                );
                //Si todo va bien y entra
                echo json_encode([
                    "status" => "success",
                    "message" => "Login exitoso",
                    "redirect" => "index.php?controller=tema&action=mostrarTemas"
                ]);
                exit();
            }
            else
            {
                //Si el
                echo json_encode([
                    "status" => "error",
                    "message" => "Usuario o password no válido"
                ]);
                exit();
            }
        }
            else
        {
            echo json_encode([
                "status" => "error",
                "message" => "No ha entrado en la condición de la sesión"
            ]);
            exit();
        }
    }

    public function apiRegistrar()
    {
        $this -> view = "login";
        isset($_POST) ? $this -> model -> insertUsuario($_POST) : print_r("error");
    }

    public function mostrarDatosUsuario() {
        // Obtenemos el ID del usuario desde la sesión

        $this -> view = "datosUsuario";

    }

    public function obtenerTotalUsuarios() {
        $totalUsuarios = $this->model->getTotalUsuarios();
        return ["totalUsuarios" => $totalUsuarios];
    }


    public function update() {
        if (isset($_POST)) {
            $usuarioId = $_SESSION['user_data']['id'];
            $usuario = $this->model->getUsuarioById($usuarioId);
            $usuario->nombre = $_POST['nombre'];
            $usuario->apellido = $_POST['apellido'];
            $usuario->username = $_POST['username'];
            $usuario->email = $_POST['email'];
            $usuario->password = $_POST['password'];
            $this->model->updateUsuario($usuario);
            header("Location: index.php?controller=usuario&action=mostrarDatosUsuario");
            exit();
        }
    }

    public function cerrarSesion() {
        // Aquí destruyes la sesión y rediriges al usuario
        session_start(); // Asegúrate de que la sesión esté iniciada
        session_unset(); // Limpia todas las variables de sesión
        session_destroy(); // Destruye la sesión

        // Redirige al usuario a la página de inicio de sesión
        header("Location: index.php?controller=usuario&action=login");
        exit();
    }

    public function mostrarNombreUsuario() {
        $usuarioId = $_SESSION['user_data']['id']; // Obtiene el ID del usuario de la sesión

        // Obtener los datos del usuario
        $usuario = $this->model->getUsuarioById($usuarioId);

        // Verifica si el usuario fue encontrado
        if ($usuario) {
            // Asigna los datos del usuario a $dataToView
            $dataToView["nombre"] = $usuario['nombre']; // Asegúrate de que el nombre esté disponible en el resultado

            // Establece la vista
            $this->view = 'nombreUsuario'; // Nombre de la vista donde se mostrará el nombre

            // Devuelve los datos a la vista
            return $dataToView;
        } else {
            // Manejo de error si el usuario no se encuentra
            return ['error' => 'Usuario no encontrado'];
        }
    }




}
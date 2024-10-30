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
                    "foto_perfil" => $row->foto_perfil,
                    "username" => $row->username
                );
                //Si
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
                "message" => "sesion",
                "redirect" => "index.php?controller=tema&action=mostrarTemas"
            ]);
            exit();
        }
    }

    public function apiRegistrar()
    {
        $this -> view = "login";
        isset($_POST) ? $this -> model -> insertUsuario($_POST) : print_r("error");
        echo json_encode([
            "status" => "success",
            "message" => "Usuario creado correctamente"
        ]);
        exit();
    }

    public function mostrarDatosUsuario() {
        // Obtenemos el ID del usuario desde la sesión

        $this -> view = "datosUsuario";
        
    }

    public function mostrarActividad(){
        $this->view = "actividad";
        $usuario = $_SESSION["user_data"];

        $page = isset($_GET["page"]) ? $_GET["page"]:1;
        $pagination = 2;

        $preguntas_pag = $this->model->getActividadPaginated("Usuario1", $pagination, $page);

        $preguntas = $preguntas_pag[0];
        $paginas = [$preguntas_pag[1], $preguntas_pag[2]];

        return[
            "preguntas_pag" => $preguntas_pag,
            "preguntas" => $preguntas,
            "paginas" => $paginas
        ];

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

            $usuarioAlmacenado = $this->model->getUsuarioByEmail($_POST['email']);
            if (password_verify($_POST["actualPassword"] , $usuarioAlmacenado->password)) {
                $usuario->password = password_hash($_POST['nuevaPassword'], PASSWORD_BCRYPT);
            } else {
                echo "La contraseña actual es incorrecta";
            }
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



}
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



    public function editarPerfil() {
        $this -> view = "vistaPrincipal/datosUsuario";
    }

    public function datosUsuario() {
        // Si no se pasa un ID de usuario, usamos el ID del usuario logueado
        $usuarioId = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_data']['id'];
        $usuario = $this->model->getUsuarioById($usuarioId);
        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
        exit;
    }


    public function confirmDelete() {
        try {
            if (!isset($_POST["idUsuario"])) {
                echo json_encode([
                    "status" => "error", "message" => "error"
                ]);
            } else {
                $usuarioId = $_POST['idUsuario'];
            }
            $this->model->delete($usuarioId);
            echo json_encode([
                "status" => "success",
                "message" => "success"
            ]);
            exit();
        } 
        catch (Error $e) {
            echo json_encode([
                "status" => "error",
                "message" => "El error es del catch: ".$e
            ]);
            exit();
        }
    }

    public function update() {
        if (isset($_POST)) {
            if (isset($_POST['idUsuario'])) {
                $usuarioId = $_POST['idUsuario'];
            }
            // Obtener el usuario por ID
            $usuario = $this->model->getUsuarioByIdObj($usuarioId);

            // Actualizar los campos
            $usuario->nombre = $_POST['nombre'];
            $usuario->apellido = $_POST['apellido'];
            $usuario->username = $_POST['username'];
            $usuario->email = $_POST['email'];

            // Solo actualizar la contraseña si se ha proporcionado
            if (!empty($_POST["actualPassword"])) {

                // Verificar contraseña
                $usuarioAlmacenado = $this->model->getUsuarioByEmail($usuario->email);
                if ($usuarioAlmacenado && password_verify($_POST["actualPassword"], $usuarioAlmacenado->password)) {

                    // Solo actualiza la contraseña si se proporciona una nueva
                    if (!empty($_POST['nuevaPassword'])) {
                        $usuario->password = password_hash($_POST['nuevaPassword'], PASSWORD_BCRYPT);
                    }

                } else {
                    echo "La contraseña actual es incorrecta.";
                    return;
                }
            }

            // Actualizar usuario en la base de datos
            $this->model->updateUsuario($usuario);

            // Redirigir a la página de los datos del usuario actualizado
            header("Location: index.php?controller=usuario&action=mostrarDatosUsuario");
            exit();
        }
    }

    public function create() {
        if (isset($_POST)) {
            $usuario = new stdClass();
            $usuario->nombre = $_POST['nombre'];
            $usuario->apellido = $_POST['apellido'];
            $usuario->username = $_POST['username'];
            $usuario->email = $_POST['email'];
            $usuario->foto_perfil = 'assets/img/fotoPorDefecto.png';
            $usuario->rol = $_POST['rol'];

            // Confirmar contraseña
            if ($_POST["nuevaPassword"] === $_POST["repetirPassword"]) {
                $usuario->password = password_hash($_POST['nuevaPassword'], PASSWORD_BCRYPT);
            } else {
                echo "Las contraseñas no coinciden.";
                return;
            }

            // Crear usuario
            $this->model->createUsuario($usuario);
            header("Location: index.php?controller=usuario&action=mostrarDatosUsuario");
            exit();
        }
    }

    public function updateFoto() {
        if (isset($_POST)) {
            if (isset($_POST['idUsuario'])) {
                $usuarioId = $_POST['idUsuario'];
            }

            $usuario = $this->model->getUsuarioById($usuarioId);


            if (isset($_FILES['nuevaFoto']) && $_FILES['nuevaFoto']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['nuevaFoto']['tmp_name'];
                $fileMimeType = mime_content_type($fileTmpPath);
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];



                if (in_array($fileMimeType, $allowedMimeTypes)) {
                    $fileName = uniqid() . '-' . basename($_FILES['nuevaFoto']['name']);
                    $uploadFileDir = 'assets/upload/fotoPerfil/';
                    $destPath = $uploadFileDir . $fileName;



                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        //$usuario->foto_perfil = $destPath;

                        $this->model->updateFoto($usuario["id"], $destPath);
                        header("Location: index.php?controller=usuario&action=mostrarDatosUsuario");
                        exit();
                    } else {
                        echo "Error al mover el archivo de imagen.";
                        return;
                    }
                } else {
                    echo "Tipo de archivo no permitido. Solo se aceptan JPEG, PNG, GIF y WEBP.";
                    return;
                }
            } else {
                echo "No se subió ningún archivo o hubo un error al cargar la imagen.";
                header("Location: index.php?controller=usuario&action=mostrarDatosUsuario");
                exit();
            }
        }
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
                    "username" => $row->username,
                    "foto_perfil" => $row->foto_perfil,
                    "rol" => $row->rol
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
        elseif(isset($_SESSION["is_logged_in"]) && isset($_SESSION["user_data"]["id"]))
        {
            echo json_encode([
                "status" => "success",
                "message" => "Usuario con sesión iniaciada",
                "redirect" => "index.php?controller=tema&action=mostrarTemas"
            ]);
            exit();
        }
        else 
        {
            echo json_encode([
                "status" => "error",
                "message" => "No ha entrado en la condición de la sesión",
                "datosDeSesion" => $_SESSION["user_data"]["id"]." is loged"
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

    public function obtenerTotalUsuarios() {
        $totalUsuarios = $this->model->getTotalUsuarios();
        return ["totalUsuarios" => $totalUsuarios];
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


    public function marcarNotificacionComoLeida()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_notificacion']) && isset($_POST['id_pregunta'])) {
            $id_notificacion = $_POST['id_notificacion'];
            $id_pregunta = $_POST['id_pregunta'];

            // Marcar la notificación como leída
            $this->model->marcarNotificacionComoLeida($id_notificacion);

            // Redirigir a la página de la pregunta
            header("Location: index.php?controller=respuesta&action=view&id_pregunta=" . $id_pregunta);
            exit;
        } else {
            // Si no se recibieron los datos esperados, redirigir a la página principal
            header("Location: index.php");
            exit;
        }
    }

    public function marcarTodasNotificacionesComoLeidas() {
        if (isset($_GET['id_usuario'])) {
            $id_usuario = $_GET['id_usuario'];
            $result = $this->model->marcarTodasNotificacionesComoLeidas($id_usuario);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['success' => false, 'error' => 'ID de usuario no proporcionado']);
        }
        exit;
    }

    public function mostrarDatosUsuario() {
        $this -> view = "principalUsuario";
    }

    public function mostrarPrincipal(){
        if (!isset($_POST["vista"])){
            echo json_encode([
                "status" => "error",
                "message" => "Vista no especificada"
            ]);
            exit();
        } else {
            $vista = $_POST["vista"];
        }

        $mostrar_usuario = "";
        ob_start();
        switch ($vista){
            case "DatosUsuario":
                $id_usuario = $_SESSION["user_data"];
                $usuario = $this->model->getUsuarioById($id_usuario["id"]);


                include "view/usuario/vistaPrincipal/datosUsuario.html.php";
                break;
            case "Actividad":
                include "view/usuario/vistaPrincipal/actividad.html.php";
                break;
            case "PanelControl":
                include "view/usuario/vistaPrincipal/gestionUsuario.html.php";
                break;
            default:
                echo json_encode([
                    "status" => "error",
                    "messaje" => "ERROR Vista switch"
                ]);
                exit();
        }

        $htmlPrincipal = ob_get_clean();

        echo json_encode([
            "status" => "success",
            "data" => [
                "html" => $htmlPrincipal,
                "usuario" => $mostrar_usuario
            ]
        ]);
        exit();


    }

    public function mostrarActividad(){

        if (!isset($_POST["username"])){
            echo json_encode([
                "status" => "error",
                "messaje" => "Usuario no especificada"
            ]);
            exit();
        } else {
            $usuario = $_POST["username"];
        }

        if (!isset($_POST["vista"])){
            echo json_encode([
                "status" => "error",
                "messaje" => "Vista no especificada"
            ]);
            exit();
        } else {
            $vista = $_POST["vista"];
        }

        $page = $_POST["page"] ?? 1;

        $pagination = 10;

        $actividad_pag = $this->model->getActividadPaginated($usuario, $pagination, $vista, $page);
        $actividad = $actividad_pag[0];
        $paginas = [$actividad_pag[1], $actividad_pag[2]];

        // Carga el archivo HTML adecuado y pasa los datos
        ob_start(); // Inicia un buffer de salida, NECESARIO para cargar archivos HTML externos
        switch ($vista){
            case "Preguntas_Usuario":
                include "view/usuario/actividad/preguntas.html.php";
                break;
            case "Respuestas_Usuario":
                include "view/usuario/actividad/respuestas.html.php";
                break;
            case "Guardados":
                /*
                $preguntas_pag = $this->model->getGuardadosPaginated($usuario, $pagination, $vista, "Pregunta", $page);
                $respuestas_pag = $this->model->getGuardadosPaginated($usuario, $pagination, $vista, "Respuesta", $page);

                $actividad = [$preguntas_pag, $respuestas_pag];
                */


                include "view/usuario/actividad/guardados.html.php";
                break;
            default:
                echo json_encode([
                    "status" => "error",
                    "messaje" => "ERROR Vista switch"
                ]);
                exit();
        }

        $contenidoHtml = ob_get_clean(); // Obtiene el contenido del buffer y lo guarda en $contenidoHtml

        echo json_encode([
            "status" => "success",
            "data" => [
                "actividad" => $actividad,
                "paginas" => $paginas,
                "html" => $contenidoHtml
            ]
        ]);
        exit();

    }

    public function mostrarGestion(){

        if (!isset($_POST["vista"]) ){
            echo json_encode([
                "status" => "error",
                "message" => "Vista no especificada"
            ]);
            exit();
        } else {
            $vista = $_POST["vista"];
        }

        /*
         * Hacemos una carga del html en un espacio de memoria en el servidor sin devolverlo al cliente (sin mostrarlo
         * en el navegador).
         * Haciendo que el código de php actué y lo guardamos en una varible el contenido de ese htnl
         * con los datos guardados y se lo pasamos al JavaScript para que lo pegue.*/

        ob_start();
        switch ($vista){
            case "Gestion":
                $listaUsuarios = $this->model->getUsuarios();
                include "view/usuario/gestion/listaUsuarios.html.php";
                break;
            case "CrearUsuario":
                include "view/usuario/gestion/nuevoUsuario.html.php";
                break;
            default:
                echo json_encode([
                    "status" => "error",
                    "message" => "ERRO vista switch"
                ]);
                exit();
        }

        $contenidoHtml = ob_get_clean();

        echo json_encode([
            "status" => "success",
            "data" => [
                "html" => $contenidoHtml
            ]
        ]);
        exit();




    }


    public function mostrarGestionUsuario() {
        $rolUsuario = $_SESSION['user_data']['rol'] ?? 'admin';
        $this -> view = "listaUsuarios";
        if ($rolUsuario === 'gestor') {
            $users = $this->model->getUsuarios();
        } else {
            $users = $this->model->getUsers();
        }
        include __DIR__ . '/../view/layout/header.php';
        include __DIR__ . '/../view/usuario/gestion/listaUsuarios.html.php';
    }

    public function nuevoUsuario() {
        if($this->revisarPrivilegios($_SESSION['user_data']['rol']) == false) {
            echo json_encode([
                "status" => "error",
                "message" => "No tiene permisos para acceder a esta página",
                "redirect" => "index.php?controller=usuario&action=mostrarDatosUsuario&id".$_SESSION['user_data']['id']
            ]);
            exit();
        }
        $this -> view = "nuevoUsuario";
    }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function revisarPrivilegios($rol)
    {
        if($rol == "admin" || $rol == "gestor")
        {
            return true;
        }
        return false;
    }

}
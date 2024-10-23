<?php
session_start();

require_once "config/config.php";
require_once "model/db.php";


// Controlador y acción por defecto
if (!isset($_GET["controller"])) $_GET["controller"] = constant("DEFAULT_CONTROLLER");
if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

// Construir la ruta del controlador
$controller_path = "controller/" . $_GET["controller"] . "Controller.php";

// Verificar si el archivo del controlador existe
if (!file_exists($controller_path)) {
    $controller_path = "controller/" . constant("DEFAULT_CONTROLLER") . "Controller.php";
}

// Incluir el controlador
require_once $controller_path;

// Determinar el nombre del controlador
$controllerName = $_GET["controller"] . "Controller";
$controller = new $controllerName();

// Inicializar la variable para los datos a enviar a la vista
$dataToView = array();

// Llamar a la acción correspondiente del controlador
if (method_exists($controller, $_GET["action"])) {
    $dataToView = $controller->{$_GET["action"]}();
}

// Incluir las vistas
if($_GET["action"] != "login"){
    require_once 'view/layout/header.php';
    require_once 'view/'.$_GET["controller"].'/'.$controller->view.'.html.php';
    require_once 'view/layout/footer.php';
} else {
    require_once 'view/'.$_GET["controller"].'/'.$controller->view.'.html.php';
}

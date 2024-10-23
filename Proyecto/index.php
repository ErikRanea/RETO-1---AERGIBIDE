<?php
session_start();
require_once "config/config.php";
require_once "model/db.php";


//Se toman los valores de la sesion


if (!isset($_SESSION['user_data']['id']) && !isset($_SESSION['enSesion']))
{
    $_SESSION['enSesion'] = true;
    header("Location: index.php?controller=usuario&action=login");
    exit(0);
}

if(!isset($_SESSION['tout']))
{
  $_SESSION['tout'] = time();
}
else
{
  
  if(($_SESSION['tout']+3600) < time())
  {

    session_destroy();
    header("Location: index.php?controller=usuario&action=login");
    exit(0);
  }
  $_SESSION['tout'] = time();
}


// Verificar si la solicitud es AJAX
$isAjaxRequest = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

if (!isset($_GET["controller"])) $_GET["controller"] = constant("DEFAULT_CONTROLLER");
if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");


$controller_path = "controller/" . $_GET["controller"] . "Controller.php";


if (!file_exists($controller_path)) {
    $controller_path = "controller/" . constant("DEFAULT_CONTROLLER") . "Controller.php";
}


require_once $controller_path;


$controllerName = $_GET["controller"] . "Controller";
$controller = new $controllerName();

$dataToView = array();


if (method_exists($controller, $_GET["action"])) {
    $dataToView = $controller->{$_GET["action"]}();
}

if ($isAjaxRequest) {
    echo json_encode($dataToView);
    exit; // Importante: salir del script para evitar cargar las vistas
}

// Incluir las vistas si no es una solicitud AJAX
if($_GET["action"] != "login"){
    require_once 'view/layout/header.php';
    require_once 'view/'.$_GET["controller"].'/'.$controller->view.'.html.php';
    require_once 'view/layout/footer.php';
} else {
    mostrarLogin();
}

function mostrarLogin()
{
    require_once 'view/usuario/login.html.php';
}
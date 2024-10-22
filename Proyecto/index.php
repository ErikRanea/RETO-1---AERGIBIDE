<?php
require_once 'config/config.php';
require_once 'model/db.php';

if(!isset($_GET["controller"])) $_GET["controller"] =
    constant("DEFAULT_CONTROLLER");
if(!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

$controller_path = 'controller/'.$_GET["controller"].'Controller.php';

if(!file_exists($controller_path)) $controller_path =
    'controller/'.constant("DEFAULT_CONTROLLER").'.php';

    
require_once $controller_path;
$controllerName = $_GET["controller"].'Controller';
$controller = new $controllerName();

$dataToView["data"] = array();
/* dataToView es lo que sea la acción del controlador */
if(method_exists($controller,$_GET["action"])) $dataToView["data"] =
    $controller->{$_GET["action"]}();
    
if($_GET["action"] != "login"){
require_once 'view/layout/header.php';
require_once 'view/'.$_GET["controller"].'/'.$controller->view.'.html.php';
require_once 'view/layout/footer.php';
}
else{
    require_once 'view/'.$_GET["controller"].'/'.$controller->view.'.html.php';
}
?>

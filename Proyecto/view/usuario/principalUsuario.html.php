<?php
$usuario = $_SESSION["user_data"];
//print_r($usuario)
?>

<link rel="stylesheet" href="assets/css/actividad.css">
<div class="containerPerfil">
    <div class="panelLateral">
        <div class="botonesContainer">
            <button class="btn btnCrear btnPanelLateral" id="btnDatos">Datos de Usuario</button>
            <button class="btn btnCrear btnPanelLateral" id="btnActividad">Actividad</button>
            <?php if ( $usuario["rol"] == "admin" || $usuario["rol"] == "gestor" ): ?>
                <button class="btn btnCrear btnPanelLateral" id="btnPanelControl">Panel de Control</button>
            <?php endif; ?>
        </div>
    </div>

    <div id="panelPrincipalUsuario">

    </div>
</div>
